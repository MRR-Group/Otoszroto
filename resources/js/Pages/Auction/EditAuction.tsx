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
                <input type="text" placeholder="Name" name="name" defaultValue={auction.name}/>
                {errors?.name && <p>{errors.name}</p>}

                <input type="text" placeholder="Description" name="description" defaultValue={auction.description}/>
                {errors?.description && <p>{errors.description}</p>}

                <input type="number" placeholder="Price" name="price" defaultValue={auction.price}/>
                {errors?.price && <p>{errors.price}</p>}

                <input type="number" placeholder="Model id" name="model_id" defaultValue={auction.model_id}/>
                {errors?.model_id && <p>{errors.model_id}</p>}

                <input type="number" placeholder="Category id" name="category_id" defaultValue={auction.category_id}/>
                {errors?.category_id && <p>{errors.category_id}</p>}

                <input type="number" placeholder="Condition" name="condition" defaultValue={auction.condition}/>
                {errors?.condition && <p>{errors.condition}</p>}

                <input type="number" placeholder="Auction State" name="auction_state" defaultValue={auction.auction_state}/>
                {errors?.auction_state && <p>{errors.auction_state}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
