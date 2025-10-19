import React, {PropsWithChildren} from 'react';
import {usePage} from "@inertiajs/react";
import {Navbar} from "@/Components/Navbar";
import {Notification} from "@/Components/Notification";
import {type Flash} from "@/Types/flash";
import {type User} from "@/Types/user";

type Props = {
    flash: Flash;
    user: User;
    errors: { message?: string, }
}

export function MainTemplate({children}: PropsWithChildren) {
    const page = usePage<Props>();

    return <>
        <Notification errors={page.props.errors} flash={page.props.flash}/>
        <Navbar user={page.props.user}/>
        {children}
    </>
}
