import { Title } from "@/Components/Title";
import { Auction } from "@/Types/auction";
import { Panel } from "@/Components/Panel";
import { Text } from "@/Components/Text";
import { Button, FormButton } from "@/Components/Button";
import { useState } from "react";
import { ButtonPrimary } from "@/Components/ButtonPrimary";
import exampleImage from "@/Assets/example.png"
import dayjs from "dayjs";
import { secondsAgo, secondsToTimeParts, timeToString } from "@/Utils/Time";

type Props = {
  auction: Auction,
}

export function ShowAuction({auction}: Props) {
  const [showPhone, setShowPhone] = useState(false);

  return (
    <div className='w-full p-4 mt-5 mx-auto md:px-10'>
      <div className="flex flex-col md:flex-row w-full justify-center gap-5 md:gap-6">
        <div className="max-w-3xl w-full">
          <Title type='h2'>Szczegóły ogłoszenia</Title>
          <div className="relative w-full aspect-square overflow-hidden rounded-xl">
            <img
              src={exampleImage}
              alt={auction.name}
              className="absolute inset-0 w-full h-full object-cover select-none"
            />
          </div>
        </div>
    
        <Panel className="w-full md:max-w-xl h-min mt-0 md:mt-9">
          <Title type="h2">{auction.name}</Title>

          <Text>
            <b>Auto:</b> {auction.model.brand.name} {auction.model.name}
          </Text>

          <Text>
            <b>Stan:</b> {auction.condition}
          </Text>

          <Text>
            <b>Wystawiono:</b> {timeToString(secondsToTimeParts(secondsAgo(auction.createdAt)))} temu
          </Text>

          <Text>
            <b>Lokalizacja:</b> {auction.city}
          </Text>

          <Text>
            <b>Wystawiający:</b> {auction.owner.firstname} {auction.owner.surname}
          </Text>

          <Text>
            <b>Email:</b> {auction.owner.email}
          </Text>

          <div className="mt-2">
            {!showPhone && <ButtonPrimary text="Telefon" onClick={() => setShowPhone(true)} /> }
          
            {(showPhone && (
              <div className="flex flex-col text-sm pt-2 items-start">
                <Text>{auction.owner.phone}</Text>
                <div className="text-primary font-bold select-none transition-colors hover:text-accent cursor-pointer" onClick={() => setShowPhone(false)}>Schowaj</div>
              </div>
            ))}
          </div>

          <div className="mt-4 flex justify-between">
            <Button text="Powrót" onClick={() => window.history.back()} />
            <FormButton text="Zgłoś ogłoszenie" url={`/auctions/${auction.id}/report`}  />
          </div>
        </Panel>
      </div>
    </div>
  );
}
