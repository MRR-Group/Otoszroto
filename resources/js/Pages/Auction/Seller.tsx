import { Button } from "@/Components/Button";
import { ButtonPrimary } from "@/Components/ButtonPrimary";
import { Input } from "@/Components/Input";
import { Panel } from "@/Components/Panel";
import { Select } from "@/Components/Select";
import { Tag } from "@/Components/Tag";
import { Text } from "@/Components/Text";
import { Title } from "@/Components/Title";
import { Auction } from "@/Types/auction";
import { Brand } from "@/Types/brand";
import { Category } from "@/Types/category";
import { Model } from "@/Types/model";
import { Pagination } from "@/Types/pagination";
import { useEffect, useMemo, useState } from "react";
import { useSearchParams } from "@/Hooks/UseSearchParams";
import { MinMaxInput } from "@/Components/MinMaxInput";
import { AuctionView } from "@/Components/PageParts/AuctionView";
import { PaginationNav } from "@/Components/PageParts/PaginationNav";
import { router } from "@inertiajs/react";
import { usePlurals } from "@/Utils/Plurals";

type Props = {
  auctions: Pagination<Auction[]>,
  categories: Category[],
  brands: Brand[],
  models: Model[],
}

const AuctionStatus = [
  {
    value: "aktywna",
    text: "Aktywna"
  },
  {
    value: "zakończona",
    text: "Zakończona"
  },
  {
    value: "anulowana",
    text: "Anulowana"
  },
]

const Conditions = [
  {
    value: "fabrycznie nowy",
    text: "Fabrycznie nowy"
  },
  {
    value: "prawie nowy",
    text: "Prawie nowy"
  },
  {
    value: "w dobrym stanie",
    text: "W dobrym stanie"
  },
  {
    value: "w zadawalającym stanie",
    text: "W zadawalającym stanie"
  },
  {
    value: "uszkodzony",
    text: "Uszkodzony"
  },
  {
    value: "na części",
    text: "Na części"
  },
]

const ItemPerPage = [20, 50, 100]

const Sort = [
  {
    id: "price-asc",
    text: "Cena ↑",
    value: "price",
    order: "asc" as const,
  },
  {
    id: "price-desc",
    value: "price",
    text: "Cena ↓",
    order: "desc" as const,
  },
  {
    id: "name-asc",
    value: "name",
    text: "A → Z",
    order: "asc" as const,
  },
  {
    id: "name-desc",
    value: "name",
    text: "Z → A",
    order: "desc" as const,
  },
  {
    id: "created_at-desc",
    value: "created_at",
    text: "Najnowsze",
    order: "desc" as const,
  },
  {
    id: "created_at-asc",
    value: "created_at",
    text: "Najstarsze",
    order: "asc" as const,
  },
];

type QueryParams = {
  sort?: string,
  order?: "desc" | "asc",
  search?: string,
  category?: number,
  brand?: number,
  model?: number,
  status?: string,
  condition?: string,
  price_min?: number,
  price_max?: number,
  per_page?: number,
  page?: number,
}

export function Seller({auctions, brands, categories, models}: Props) {
  const { params, isNavigating, patchParams } = useSearchParams<QueryParams>({ only: ["auctions"] });

  const [auctionState, setAuctionState] = useState(params.status);
  const [selectedCategory, setSelectedCategory] = useState(asNumber(params.category));
  const [selectedBrand, setSelectedBrand] = useState(asNumber(params.brand));
  const [selectedModel, setSelectedModel] = useState(asNumber(params.model));
  const [selectedState, setSelectedState] = useState(params.condition);
  const [priceMin, setPriceMin] = useState(asNumber(params.price_min));
  const [priceMax, setPriceMax] = useState(asNumber(params.price_max));
  const [search, setSearch] = useState(params.search);
  const [sortBy, setSortBy] = useState(params.sort);
  const [sortOrder, setSortOrder] = useState(params.order);
  const [perPage, setPerPage] = useState(asNumber(params.per_page));
  const [page, setPage] = useState(asNumber(params.page));

  const brandModels = useMemo(() => models.filter(model => model.brand.id === selectedBrand), [models, selectedBrand])

  const tranlsateResult = usePlurals("wynik", "wyniki", "wyników");

  function asNumber(data: number | string | undefined): number | undefined {
    if (data === undefined) {
      return undefined;
    }
    
    if (typeof(data) === "number") {
      return data;
    }

    return parseFloat(data);
  }

  function setSort(sortBy: string, order: "asc" | "desc") {
    setSortBy(sortBy);
    setSortOrder(order);
  }

  function clearForm() {
    setAuctionState(undefined);
    setSelectedCategory(undefined);
    setSelectedBrand(undefined);
    setSelectedModel(undefined);
    setSelectedState(undefined);
    setPriceMin(undefined);
    setPriceMax(undefined);
    setSearch(undefined);

    patchParams({
      category: undefined,
      brand: undefined,
      model: undefined,
      condition: undefined,
      price_min: undefined,
      price_max: undefined,
      search: undefined,
      per_page: undefined,
      order: sortOrder,
      sort: sortBy,
    });
  }

  function applyForm() {
    patchParams({
      category: selectedCategory,
      brand: selectedBrand,
      model: selectedModel,
      status: auctionState,
      condition: selectedState,
      price_min: priceMin,
      price_max: priceMax,
      search: search,
      per_page: perPage,
      order: sortOrder,
      sort: sortBy,
    });
  }

  useEffect(() => {
    patchParams({
      category: selectedCategory,
      brand: selectedBrand,
      model: selectedModel,
      condition: selectedState,
      price_min: priceMin,
      price_max: priceMax,
      search: search,
      per_page: perPage,
      order: sortOrder,
      sort: sortBy,
      page: page,
    });
  // This effect is intentionally triggered only sorting and pagination changes.
  // Filters and search are applied explicitly via a form submit action,
  // so including them as dependencies would cause unintended URL updates
  // and break the expected user interaction flow.
  //
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [sortBy, sortOrder, perPage, page])

  return (
    <div className='w-full p-4 mt-5 mx-auto md:px-10'>
      <Title type='h2'>Przeglądaj twoje oferty</Title>
      <div className="w-full h-min flex flex-col md:flex-row gap-4">
        <Panel className="w-full md:max-w-80 h-min">
          <Text color="muted">Kategorie</Text>
          <div className='flex flex-wrap gap-2 mt-2'>
            {categories.map(category => (
              <Tag 
                key={category.id} 
                selected={selectedCategory === category.id} 
                small
                onClick={() => selectedCategory != category.id ? setSelectedCategory(category.id) : setSelectedCategory(undefined)}
              >
                {category.name}
              </Tag>
            ))}
          </div>

          <div className='flex flex-col gap-2 mt-4'>
            <Text color='muted'>Szukaj</Text>
            <Input 
              name="search"
              placeholder="np. alternator" 
              value={search} 
              onChange={(e) => setSearch(e.target.value)} 
            />
          </div>

          <div className='flex flex-col gap-2 mt-4'>
            <Text color='muted'>Status Aukcji</Text>
            <Select
              placeholder='Dowolny'
              items={AuctionStatus}
              selected={auctionState}
              onChange={setAuctionState}
              onClear={() => setAuctionState(undefined)}
              item={(item) => item}
              clearable
            />
          </div>

          <div className='flex flex-col gap-2 mt-4'>
            <Text color='muted'>Marka</Text>
            <Select
              placeholder='Dowolna'
              items={brands}
              selected={selectedBrand}
              onChange={setSelectedBrand}
              onClear={() => setSelectedBrand(undefined)}
              item={(item) => ({
                value: item.id,
                text: item.name,
              })}
              clearable
            />
          </div>

          <div className='flex flex-col gap-2 mt-4'>
            <Text color='muted'>Model</Text>
            <Select
              placeholder='Dowolny'
              items={brandModels}
              selected={selectedModel}
              onChange={setSelectedModel}
              onClear={() => setSelectedModel(undefined)}
              item={(item) => ({
                value: item.id,
                text: item.name,
              })}
              clearable
            />
          </div>

          <div className='flex flex-col gap-2 mt-4'>
            <Text color='muted'>Stan</Text>
            <Select
              placeholder='Dowolny'
              items={Conditions}
              selected={selectedState}
              onChange={setSelectedState}
              onClear={() => setSelectedState(undefined)}
              item={(item) => item}
              clearable
            />
          </div>

          <div className='flex flex-col gap-2 mt-4'>
            <Text color='muted'>Cena (PLN)</Text>

            <div className='flex gap-2'>
              <MinMaxInput 
                max={priceMax} 
                min={priceMin} 
                onChange={({ min, max }) => {
                  setPriceMin(min);
                  setPriceMax(max);
                }}
                allowNegative={false}
                float 
                full
              />
            </div>
          </div>
          
          <div className='flex gap-2 pt-4 justify-end'>
            <Button 
              text='Wyczyść' 
              disabled={isNavigating}
              onClick={clearForm} 
            />
            
            <ButtonPrimary 
              text='Zastosuj'
              loading={isNavigating}
              onClick={applyForm} 
            />
          </div>
        </Panel>
        
        <div className='mt-4 flex flex-wrap gap-4 w-full'>
          <div className='w-full flex justify-between items-center'>
            <div className='w-min whitespace-nowrap'>
              <Tag>{auctions.meta.total} {tranlsateResult(auctions.meta.total)}</Tag>
            </div>

            <div className='flex gap-2 items-center'>
              <div className='flex gap-2 flex-col md:flex-row items-center'>
                <Text color="muted">Sortuj</Text>
                <Select
                  placeholder="Domyślnie"
                  items={Sort}
                  selected={`${sortBy}-${sortOrder}` as string}
                  onChange={id => Sort.map(item => item.id === id && setSort(item.value, item.order))}
                  onClear={() => setSort("id", "asc")}
                  item={item => ({ text: item.text, value: item.id })}
                  clearable
                />
              </div>

              <div className='flex gap-2 flex-col md:flex-row items-center'>
                <Text color="muted">Na stronę</Text>
                <Select
                  placeholder="10"
                  items={ItemPerPage}
                  selected={perPage}
                  onChange={value => setPerPage(value)}
                  onClear={() => setPerPage(10)}
                  clearable
                />
              </div>
            </div>
          </div>
          
          <div className="w-full grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 min-h-10/12">
            {auctions.data.flatMap(auctions => auctions).map(auction => (
              <AuctionView key={auction.id} sellerPage singleMode={auctions.data.flatMap(auctions => auctions).length === 1} data={auction} onClick={() => router.visit(`/auctions/${auction.id}`)} />
            ))}
          </div>
          
          <div className="flex w-full justify-center">
            <PaginationNav data={auctions} onPageChange={setPage} />
          </div>
        </div>
      </div>
    </div>
  );
}
