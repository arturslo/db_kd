import NextAuth from 'next-auth'
import Providers from 'next-auth/providers'

async function loginEndpoint(credentials) {
    const loginResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/login`, {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    })

    const result = await loginResponse.json()

    if (loginResponse.ok && result) {
        return result
    }

    return null
}

async function refreshAccessToken(token) {
    const refreshResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/refresh`, {
        method: 'post',
        headers: {
            'Authorization': `Bearer ${token.accessToken}`,
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: null,
    })

    const result = await refreshResponse.json()

    if (refreshResponse.ok && result) {
        const accessToken = result.accessToken;
        const accessTokenExpires = Date.now() + result.expiresIn * 1000

        return {...token, accessToken, accessTokenExpires}
    }

    return null
}

export default NextAuth({
    providers: [
        Providers.Credentials({
            // The name to display on the sign in form (e.g. 'Sign in with...')
            name: 'Credentials',
            // The credentials is used to generate a suitable form on the sign in page.
            // You can specify whatever fields you are expecting to be submitted.
            // e.g. domain, username, password, 2FA token, etc.
            credentials: {
                Email: {label: "Email", type: "text", placeholder: "annak@gmail.com"},
                Password: {label: "Password", type: "password", placeholder: "qwerty"}
            },
            async authorize(credentials, req) {
                // Add logic here to look up the user from the credentials supplied
                const loginResult = await loginEndpoint(credentials);

                if (loginResult) {
                    // Any object returned will be saved in `user` property of the JWT
                    return loginResult
                } else {
                    // If you return null or false then the credentials will be rejected
                    return null
                    // You can also Reject this callback with an Error or with a URL:
                    // throw new Error('error message') // Redirect to error page
                    // throw '/path/to/redirect'        // Redirect to a URL
                }
            }
        })
    ],
    callbacks: {
        /**
         * @param  {object}  token     Decrypted JSON Web Token
         * @param  {object}  user      User object      (only available on sign in)
         * @param  {object}  account   Provider account (only available on sign in)
         * @param  {object}  profile   Provider profile (only available on sign in)
         * @param  {boolean} isNewUser True if new user (only available on sign in)
         * @return {object}            JSON Web Token that will be saved
         */
        async jwt(token, loginResult, account, profile, isNewUser) {
            if (loginResult) {
                const accessToken = loginResult.accessToken
                const accessTokenExpires = Date.now() + loginResult.expiresIn * 1000

                return {...token, accessToken, accessTokenExpires}
            }

            // Subsequent calls
            // Check if the expired time set has passed

            if (Date.now() < token.accessTokenExpires) {
                // Return previous token if still valid
                return token;
            }

            // Refresh the token in case time has passed
            return refreshAccessToken(token);
        }
    }
})
