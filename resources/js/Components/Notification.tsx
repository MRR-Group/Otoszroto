import React from 'react';
import {type Flash} from "@/Types/flash";

type Props = {
    errors: {
        message?: string,
    }
    flash: Flash
}

export function Notification({errors, flash}: Props) {

    return <>
        {errors?.message &&
            <div className={"bg-red-900"}>{errors.message}</div>
        }
        {flash?.error &&
            <div className={"bg-red-900"}>{flash.error}</div>
        }
        {flash?.message &&
            <div className={"bg-green-900"}>{flash.message}</div>
        }
    </>
}
