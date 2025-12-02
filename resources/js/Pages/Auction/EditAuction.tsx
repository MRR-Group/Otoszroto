import React from 'react';
import {Form} from "@inertiajs/react";
import { Auction } from "@/Types/auction";

type Props = {
    errors: any;
    auction: Auction;
}

export function EditAuction({errors,auction}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Edit auction</h1>
            <Form
                action={`/auctions/${auction.id}`}
                method="PATCH"
            >
                <input type="text" placeholder="Name" name="name" />
                {errors?.name && <p>{errors.name}</p>}

                <input type="text" placeholder="Description" name="description" />
                {errors?.description && <p>{errors.description}</p>}

                <input type="text" placeholder="Photo url" name="photo_url" />
                {errors?.photo_url && <p>{errors.photo_url}</p>}

                <input type="number" placeholder="Price" name="price" />
                {errors?.price && <p>{errors.price}</p>}

                <input type="number" placeholder="Model id" name="model_id" />
                {errors?.model_id && <p>{errors.model_id}</p>}

                <input type="number" placeholder="Category id" name="category_id" />
                {errors?.category_id && <p>{errors.category_id}</p>}

                <input type="number" placeholder="Condition" name="condition" />
                {errors?.condition && <p>{errors.condition}</p>}

                <input type="number" placeholder="Auction State" name="auction_state" />
                {errors?.auction_state && <p>{errors.auction_state}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
