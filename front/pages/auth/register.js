import Head from "next/head";
import {useState} from "react";
import {signIn} from 'next-auth/client'

export default function Register() {

async function handleSubmit(event) {
    event.preventDefault()

    const registerResponse = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/register`, {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })

    const result = await registerResponse.json()

    if (registerResponse.status === 422) {
        setErrors(result.errors)
    }

    if (!registerResponse.ok) {
        return
    }

    if (result.ClientId) {
        signIn(null, { callbackUrl: '' })
    }
}

    const [formData, setFormData] = useState({Email: "", Password: "", Firstname: "", Lastname: ""})
    const [errors, setErrors] = useState(null)

    function handleChange(e) {
        setFormData({...formData, [e.target.name]: e.target.value})
    }

    return (
        <>
            <Head>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <title>Register</title>
            </Head>
            <div className="d-flex flex-column min-vh-100 justify-content-center align-items-center">

                <form onSubmit={handleSubmit}>

                    <div className="mb-3">
                        <label htmlFor="Firstname" className="form-label">Firstname</label>
                        <input type="input" className="form-control" id="Firstname" name="Firstname" onChange={handleChange}/>
                    </div>
                    <div className="text-danger">
                        {errors?.Firstname}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="Lastname" className="form-label">Lastname</label>
                        <input type="input" className="form-control" id="Lastname" name="Lastname" onChange={handleChange}/>
                    </div>
                    <div className="text-danger">
                        {errors?.Lastname}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="Email" className="form-label">Email address</label>
                        <input type="email" className="form-control" id="Email" name="Email" onChange={handleChange}/>
                    </div>
                    <div className="text-danger">
                        {errors?.Email}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="Password" className="form-label">Password</label>
                        <input type="password" className="form-control" id="Password" name="Password" onChange={handleChange}/>
                    </div>
                    <div className="text-danger">
                        {errors?.Password}
                    </div>

                    <button type="submit" className="btn btn-primary mt-2">Register</button>
                </form>
            </div>
        </>


    )
}

// ['Firstname' => 'Janis', 'Lastname' => 'Ozols', 'Email' => 'janisozols@gmail.com', 'Password' => 'qwerty'],