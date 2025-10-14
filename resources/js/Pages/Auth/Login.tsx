import React from 'react';
import {Form, router} from "@inertiajs/react";

type Props = {
    errors: any;
}
export function Login({errors}: Props) {
    return (
        <>
            <h1>Login</h1>
            {errors?.message && <p>{errors.message}</p>}
            <a href="/register">Register</a>
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
