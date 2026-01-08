import { Auction } from "@/Types/auction"
import { Panel } from "../Panel";
import { Text } from "../Text";
import { Button } from "../Button";
import { ButtonPrimary } from "../ButtonPrimary";
import { useState } from "react";

type Props = {
  data: Auction,
  fullView?: boolean,
  onClick?: () => void,
  singleMode?: boolean,
  sellerPage?: boolean,
}

export const AuctionView = ({ data, fullView, singleMode, sellerPage, onClick }: Props) => {
  const [showPhone, setShowPhone] = useState(false);

  return (
    <Panel className={singleMode ? "h-min" : ""}>
      <div className="-m-4 mb-0">
         <div className="relative w-full aspect-square overflow-hidden rounded-xl rounded-b-none">
          <img
            src={data.photo}
            alt={data.name}
            className="absolute inset-0 w-full h-full object-cover select-none"
          />
        </div>
      </div>

      <div className="pt-2 flex justify-between">
        <div>
          <Text className="font-bold" color="text">
            {data.name}
          </Text>

          <Text className="text-xs" color="muted">
            {data.city} · {data.model.brand.name} · {data.model.name}
          </Text>
        </div>

        <div className="text-transparent bg-clip-text font-extrabold bg-gradient-to-r from-primary to-accent whitespace-nowrap text-end">
          {data.price.toFixed(2)} zł

          {sellerPage && (
            <div>
              {data.auctionState}
            </div>
          )}
        </div>
      </div>

      <div className="flex justify-between pt-3">
        {!fullView && <Button text="Podgląd" onClick={onClick} />}
        
        {!fullView && !showPhone && <ButtonPrimary text="Telefon" onClick={() => setShowPhone(true)} /> }
        
        {(!fullView && showPhone && (
          <div className="flex flex-col text-sm pt-2 items-end">
            <Text>{data.owner.phone}</Text>
            <div className="text-primary font-bold select-none transition-colors hover:text-accent cursor-pointer" onClick={() => setShowPhone(false)}>Schowaj</div>
          </div>
      ))}
      </div>
    </Panel>
  );
}
