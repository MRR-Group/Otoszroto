import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}

export function ChangePassword({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Change password</h1>
            <Form
                action="/user/change-password"
                method="POST"
            >
                <input type="password" placeholder="Current Password" name="current_password" required />
                {errors?.current_password && <p>{errors.current_password}</p>}

                <input type="password" placeholder="Password" name="password" required />
                {errors?.password && <p>{errors.password}</p>}

                <input type="password" placeholder="Confirm password" name="password_confirmation" required />

                <input type="submit"></input>
            </Form>
        </>
    );
}
