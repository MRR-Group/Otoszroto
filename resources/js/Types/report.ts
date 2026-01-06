import { User } from "./user";
import { Auction } from "./auction";

export type Report = {
    id: number;
    reporter: User;
    auction: Auction;
    reason: string;
    resolvedAt: string | null;
    createdAt: string;
    updatedAt: string;
}
