import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}

export function CreateModel({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Create model</h1>
            <Form
                action={"/auction/model"}
                method="POST"
            >
                <input type="text" placeholder="Name" name="name" required />
                {errors?.name && <p>{errors.name}</p>}

                <input type="number" placeholder="Brand id" name="brand_id" required />
                {errors?.brand_id && <p>{errors.brand_id}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
