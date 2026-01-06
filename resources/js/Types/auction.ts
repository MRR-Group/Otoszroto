import { Category } from "./category";
import { Model } from "./model";
import { User } from "./user";

export type Auction = {
    id: number;
    name: string;
    description: string;
    photo: string;
    price: number;
    city: string;
    model: Model;
    owner: User;
    category: Category;
    condition: string;
    auctionState: string;
    createAt: string,
    updatedAt: string,
}
