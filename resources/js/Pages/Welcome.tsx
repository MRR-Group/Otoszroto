import { NavButtonPrimary } from '@/Components/ButtonPrimary';
import { Input } from '@/Components/Input';
import { AuctionView } from '@/Components/PageParts/AuctionView';
import { Panel } from '@/Components/Panel';
import { Text } from '@/Components/Text';
import { Title } from '@/Components/Title';
import { Auction } from '@/Types/auction';
import { router } from '@inertiajs/react';
import React, { useState } from 'react';

type Props = {
  auctions: Auction[]
}

export function Welcome({auctions}: Props) {
  const [search, setSearch] = useState("");

  return (
    <div className='p-4 mx-auto w-full max-w-6xl'>
      <Panel className='mb-8 mt-8'>
        <Title type='h1'>
          Znajdź i sprzedaj części <br/> samochodowe w jednym miejscu
        </Title>

        <Text color='muted'>
          OtoSzroto porządkuje rozproszony rynek części używanych. <br/> Przeglądaj oferty, filtruj po marce i modelu, wystawiaj własne ogłoszenia, prosto i przejrzyście.
        </Text>

        <div className='mt-2'>
          <Text color='text' className='text-xs mb-2'>Czego szukasz?</Text>

          <div className='flex gap-4'>
            <Input placeholder='Znajdź potrzebną część' full value={search} onChange={(e) => setSearch(e.target.value)} />
            <NavButtonPrimary href={`/auctions?search=${search}`} text='Szukaj' />
          </div>
        </div>
      </Panel>

      <Title>Ostatnie ogłoszenia</Title>

      <div className='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3'>
        {auctions.map(auction => (
          <AuctionView key={auction.id} singleMode data={auction} onClick={() => router.visit(`/auctions/${auction.id}`)} />
        ))}
      </div>

    </div>
  );
}
