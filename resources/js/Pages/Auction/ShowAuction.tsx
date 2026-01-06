import { Title } from "@/Components/Title";
import { Auction } from "@/Types/auction";
import { AuctionView } from "@/Components/PageParts/AuctionView";

type Props = {
  auction: Auction,
}

export function ShowAuction({auction}: Props) {
  console.log(auction);

  return (
    <div className='w-full p-4 mt-5 mx-auto md:px-10'>
      <Title type='h2'>Szczegóły ogłoszenia</Title>
      <AuctionView data={auction} />
    </div>
  );
}
