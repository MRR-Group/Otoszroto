import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}

export function Register({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Register</h1>
            <Form
                action={"/register"}
                method="POST"
            >
                <input type="text" placeholder="Firstname" name="firstname" required />
                {errors?.firstname && <p>{errors.firstname}</p>}

                <input type="text" placeholder="Surname" name="surname" required />
                {errors?.surname && <p>{errors.surname}</p>}

                <input type="text" placeholder="Phone number" name="phone" required />
                {errors?.phone && <p>{errors.phone}</p>}

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
