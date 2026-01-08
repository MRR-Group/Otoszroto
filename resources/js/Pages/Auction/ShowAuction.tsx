import { Title } from "@/Components/Title";
import { Auction } from "@/Types/auction";
import { Panel } from "@/Components/Panel";
import { Text } from "@/Components/Text";
import { AsyncButton, Button, FormButton } from "@/Components/Button";
import { useState } from "react";
import { ButtonPrimary } from "@/Components/ButtonPrimary";
import { secondsAgo, secondsToTimeParts, timeToString } from "@/Utils/Time";
import { router, usePage } from "@inertiajs/react";
import { useMessageBox } from "@/Hooks/UseMessageBox";

type Props = {
  auction: Auction,
}

export function ShowAuction({auction}: Props) {
  const [showPhone, setShowPhone] = useState(false);
  const page = usePage();
  const { confirm } = useMessageBox();

  async function handleClose() {
    const ok = await confirm({
        title: "Zamknij ofertę",
        message: "Czy na pewno chcesz zamknąć tę ofertę?",
        confirmText: "Zamknij",
        danger: true,
    });

    if (ok) {
      await new Promise<void>((resolve, reject) => {
        router.visit(`/auctions/${auction.id}/finish`, { 
          method: "patch",
          preserveScroll: true,
          preserveState: false,
          onSuccess: () => resolve(),
          onError: (errs) => reject(errs),
        });
      });
    }
  }

    async function handleCancel() {
    const ok = await confirm({
        title: "Anuluj ofertę",
        message: "Czy na pewno chcesz anulować tę ofertę?",
        confirmText: "Anuluj",
        danger: true,
    });

    if (ok) {
      await new Promise<void>((resolve, reject) => {
        router.visit(`/auctions/${auction.id}/cancel`, { 
          method: "patch",
          preserveScroll: true,
          preserveState: false,
          onSuccess: () => resolve(),
          onError: (errs) => reject(errs),
        });
      });
    }
  }

  return (
    <div className='w-full p-4 mt-5 mx-auto md:px-10'>
      <div className="flex flex-col md:flex-row w-full justify-center gap-5 md:gap-6">
        <div className="max-w-3xl w-full">
          <Title type='h2'>Szczegóły ogłoszenia</Title>
          <div className="relative w-full aspect-square overflow-hidden rounded-xl">
            <img
              src={auction.photo}
              alt={auction.name}
              className="absolute inset-0 w-full h-full object-cover select-none"
            />
          </div>
        </div>

        <div className="w-full md:max-w-xl h-min mt-0 md:mt-9">
          <Panel className="mb-4">
            <Title type="h2">{auction.name}</Title>

            <Text>
              <b>Cena:</b> {auction.price} zł
            </Text>

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
          </Panel>

          <Panel>
            <Title>Opis</Title>
            <Text>
              {auction.description}
            </Text>

            <div className="mt-4 flex justify-between">
              <Button text="Powrót" onClick={() => window.history.back()} />
              { !!page.props.user && !auction.isOwner && !auction.wasReported && <FormButton text="Zgłoś ogłoszenie" url={`/auctions/${auction.id}/report`} /> }
              { !!page.props.user && auction.isOwner && <FormButton method="get" text="Edytuj ogłoszenie" url={`/auctions/${auction.id}/edit`} /> }
            </div>
          </Panel>

          {!!page.props.user && auction.isOwner && (
            <Panel className="mt-4">
              <Title>Status</Title>
              <Text>
                {auction.auctionState}
              </Text>

              {auction.auctionState === "aktywna" && (
                <div className="mt-4 flex justify-between">
                  <AsyncButton text="Zakończ aukcje" asyncAction={handleClose} />
                  <AsyncButton text="Anuluj aukcje" asyncAction={handleCancel} />
                </div>
              )}
            </Panel>
          )}
        </div>
      </div>
    </div>
  );
}
