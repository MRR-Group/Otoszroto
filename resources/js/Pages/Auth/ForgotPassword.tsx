import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}
export function ForgotPassword({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Reset Password</h1>
            <a href="/reset-password">Already have code</a>
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
