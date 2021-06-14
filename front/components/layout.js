import Head from "next/head";
import Link from 'next/link'

import {signIn, signOut, useSession} from 'next-auth/client'


export default function Layout({children}) {
    const [session, loading] = useSession()

    return (
        <>
            <Head>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
            </Head>
            <header>
                <div className="navbar navbar-dark bg-dark shadow-sm">
                    <div className="container">
                        <a href="#" className="navbar-brand d-flex align-items-center">
                            <strong>SHOP</strong>
                        </a>

                        <span className="navbar-text ms-auto pe-4">
                            {session?.user?.email}
                        </span>

                        {!session && <>
                            <button className="btn btn-primary" onClick={() => signIn()}>Sign in</button>
                            <Link href="/auth/register">
                                <button className="btn btn-primary ms-2">Register</button>
                            </Link>
                        </>}
                        {session && <>
                            <button className="btn btn-primary" onClick={() => signOut()}>Sign out</button>
                        </>}

                    </div>
                </div>
            </header>
            <main>{children}</main>
        </>
    )
}
