import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: {
        email: string,
        password: string,
    };
}
export function Login({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Login</h1>
            <br/>
            <a href="/forgot-password">Forgot password</a>
            <Form
                action="/login"
                method="POST"
            >
                <input type="email" placeholder="Email" name="email" required />
                {errors?.email && <p>{errors.email}</p>}

                <input type="password" placeholder="Password" name="password" required />
                {errors?.password && <p>{errors.password}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
