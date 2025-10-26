import React from 'react';
import {Form} from "@inertiajs/react";
import {type User} from "@/Types/user";

type Props = {
    user?: User;
}

export function Navbar({ user }: Props) {
    const isLoggedIn = !!user;

    if(isLoggedIn) {
        return <>
            <p className={"text-lg font-semibold"}>You are logged in as {user?.firstname} {user?.surname}</p>

            <div className={"flex items-center justify-evenly"}>
                {<Form action={"/logout"} method="POST"><button type="submit">Logout</button></Form>}
                {<a href="/user/change-password">Change password</a>}
            </div>
        </>
    }

    return (
        <div className={"flex items-center justify-evenly"}>
            {!user && <a href="/login">Login</a>}
            {!user && <a href="/register">Register</a>}
        </div>
    );
}
