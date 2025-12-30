import React from 'react';
import {Form} from "@inertiajs/react";
import { Auction } from "@/Types/auction";

type Props = {
    errors: any;
    auction: Auction;
}

export function ReportAuction({errors, auction}: Props) {
    return (
        <>
            <h1 className={"text-lg font-semibold"}>Report auction</h1>
            <Form
                action={`/auctions/${auction.id}/report`}
                method="POST"
            >
                <input type="text" placeholder="Reason" name="reason"/>
                {errors?.reason && <p>{errors.reason}</p>}

                <input type="submit"></input>
            </Form>
        </>
    );
}
