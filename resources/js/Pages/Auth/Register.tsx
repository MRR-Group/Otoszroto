import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}
export function Register({errors}: Props) {
    return (
        <>
            <h1>Register</h1>
            {errors?.message && <p>{errors.message}</p>}
            <a href="/login">Login</a>
            <Form
                action={"/register"}
                method="POST"
            >
                <input type="text" placeholder="Name" name="name" required />
                {errors?.name && <p>{errors.name}</p>}

                <input type="email" placeholder="Email" name="email" required />
                {errors?.email && <p>{errors.email}</p>}

                <input type="password" placeholder="Password" name="password" required />
                {errors?.password && <p>{errors.password}</p>}

                <input type="password" placeholder="Confirm password" name="password_confirmation" required />

                <input type="submit"></input>
            </Form>
        </>
    );
}
