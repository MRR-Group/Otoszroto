import React from 'react';
import {Form} from "@inertiajs/react";

type Props = {
    errors: any;
}

export function CreateAuction({errors}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Create auction</h1>
            <Form
                action={"/auctions"}
                method="POST"
            >
                <input type="text" placeholder="Name" name="name" required />
                {errors?.name && <p>{errors.name}</p>}

                <input type="text" placeholder="Description" name="description" required />
                {errors?.description && <p>{errors.description}</p>}

                <input type="text" placeholder="Photo url" name="photo_url" required />
                {errors?.photo_url && <p>{errors.photo_url}</p>}

                <input type="number" placeholder="Price" name="price" required />
                {errors?.price && <p>{errors.price}</p>}

                <input type="number" placeholder="Model id" name="model_id" required />
                {errors?.model_id && <p>{errors.model_id}</p>}

                <input type="number" placeholder="Category id" name="category_id" required />
                {errors?.category_id && <p>{errors.category_id}</p>}

                <input type="number" placeholder="Condition" name="condition" required />
                {errors?.condition && <p>{errors.condition}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
