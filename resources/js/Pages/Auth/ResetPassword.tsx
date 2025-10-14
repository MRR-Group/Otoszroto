import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}
export function ResetPassword({errors}: Props) {
    return (
        <>
            <h1>Reset Password</h1>
            {errors?.message && <p>{errors.message}</p>}
            <Form
                action={"/reset-password"}
                method="POST"
            >
                <input type="text" placeholder="Reset Code" name="token" required />
                {errors?.token && <p>{errors.token}</p>}

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
