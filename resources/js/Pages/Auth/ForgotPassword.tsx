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
                action={"/forgot-password"}
                method="POST"
            >
                <input type="email" placeholder="Email" name="email" required />
                {errors?.email && <p>{errors.email}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
