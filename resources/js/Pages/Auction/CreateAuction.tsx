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

                <input type="text" placeholder="City" name="city" required />
                {errors?.city && <p>{errors.city}</p>}

                <input type="file" placeholder="Photo" name="photo" accept="image/png" className={"dark:text-white"}/>
                {errors?.photo && <p>{errors.photo}</p>}

                <input type="number" placeholder="Price" name="price" required />
                {errors?.price && <p>{errors.price}</p>}

                <input type="number" placeholder="Model id" name="model_id" required />
                {errors?.model_id && <p>{errors.model_id}</p>}

                <input type="number" placeholder="Category id" name="category_id" required />
                {errors?.category_id && <p>{errors.category_id}</p>}

                <select name="condition" required>
                    <option value="fabrycznie nowy">Fabrycznie nowy</option>
                    <option value="prawie nowy">Prawie nowy</option>
                    <option value="w dobrym stanie">W dobrym stanie</option>
                    <option value="w zadawalającym stanie">W zadawalającym stanie</option>
                    <option value="uszkodzony">Uszkodzony</option>
                    <option value="na części">Na części</option>
                </select>
                {errors?.condition && <p>{errors.condition}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
