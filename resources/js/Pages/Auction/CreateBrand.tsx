import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}

export function CreateBrand({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Create brand</h1>
            <Form
                action={"/auction/brand"}
                method="POST"
            >
                <input type="text" placeholder="Name" name="name" required />
                {errors?.name && <p>{errors.name}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
