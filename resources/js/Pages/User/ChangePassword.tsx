import React from 'react';
import {Form, router} from "@inertiajs/react";

type Props = {
    errors: any;
}
export function Login({errors}: Props) {
    return (
        <>
            <h1>Change password</h1>
            {errors?.message && <p>{errors.message}</p>}
            <a href="/">Home</a>
            <Form
                action="/user/change-password"
                method="POST"
            >
                <input type="password" placeholder="Current Password" name="current_password" required />
                {errors?.current_password && <p>{errors.current_password}</p>}

                <input type="password" placeholder="Password" name="password" required />
                {errors?.password && <p>{errors.password}</p>}

                <input type="password" placeholder="Password" name="password_confirmation" required />

                <input type="submit"></input>
            </Form>
        </>
    );
}
