import React from 'react';
import {Form} from "@inertiajs/react";
type Props = {
    user?: any;
}
export function Welcome({ user }: Props) {
    console.log(user, !!user, !user);
    return (
        <>
            {!!user && <Form action={"/logout"} method="POST"><button type="submit">Logout</button></Form>}

            {!user && <a href="/login">Login</a>}
            <br/>
            {!user && <a href="/register">Register</a>}
        </>
    );
}
