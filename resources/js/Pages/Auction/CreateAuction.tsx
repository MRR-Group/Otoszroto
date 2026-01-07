import { Form, useForm } from "@inertiajs/react";
import { Title } from '@/Components/Title';
import { Panel } from '@/Components/Panel';
import { Text } from '@/Components/Text';
import { Input } from '@/Components/Input';
import { Category } from "@/Types/category";
import { Brand } from "@/Types/brand";
import { Model } from "@/Types/model";
import React, { useMemo, useState } from "react";
import { NavButton } from "@/Components/Button";
import { ButtonPrimary } from "@/Components/ButtonPrimary";
import { Select } from "@/Components/Select";
import { NumberInput } from "@/Components/NumberInput";
import { ImageInput } from "@/Components/ImageInput";
import { MultilineInput } from "@/Components/MultilineInput";

type Props = {
  categories: Category[];
  brands: Brand[];
  models: Model[];
  errors: Partial<{
    name: string;
    description: string;
    city: string;
    model_id: string;
    category_id: string;
    condition: string;
    price: string;
    photo: string;
  }>;
}

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

export function CreateAuction({ errors, categories, brands, models }: Props) {
  const form = useForm({
    name: "",
    description: "",
    city: "",
    price: 0,
    model_id: undefined as (number | undefined),
    category_id: undefined as (number | undefined),
    condition: undefined as (string | undefined),
    photo: undefined as (File | undefined),
  });

  const [selectedBrand, setSelectedBrand] = useState(asNumber(undefined));
  const brandModels = useMemo(() => models.filter(model => model.brand.id === selectedBrand), [models, selectedBrand])

  function asNumber(data: number | string | undefined): number | undefined {
    if (data === undefined) {
      return undefined;
    }
    
    if (typeof(data) === "number") {
      return data;
    }

    return parseFloat(data);
  }

  const submitDisabled = form.processing;

  const submit = (e: React.MouseEvent) => {
    e.preventDefault();
    
    if (submitDisabled) {
        return;
    }

    form.post("/auctions");
  };

  return (
    <div className='w-full p-8'>
      <Panel className="w-full mx-auto max-w-4xl">
        <Title type="h2">Stwórz aukcje</Title>
        <Form action="/register" method="POST" className="flex flex-col gap-3">
          <div className="flex flex-col gap-2">
            <Text>Nazwa</Text>
            <Input
              name="name"
              placeholder="Nazwa"
              value={form.data.name}
              onChange={(e) => {
                form.clearErrors("name");
                form.setData("name", e.target.value);
              }}
            />
            {(errors?.name || form.errors.name) && (
              <p className="text-danger text-sm">
                {errors?.name ?? form.errors.name}
              </p>
            )}
          </div>

          <div className='flex flex-col gap-2'>
            <Text>Kategoria</Text>
            <Select
              placeholder='Kategoria'
              items={categories}
              selected={form.data.category_id}
              onChange={(category) => form.setData("category_id", category)}
              onClear={() => form.setData("category_id", undefined)}
              item={(item) => ({
                value: item.id,
                text: item.name,
              })}
              clearable
            />
            {(errors?.category_id || form.errors.category_id) && (
              <p className="text-danger text-sm">
                {errors?.category_id ?? form.errors.category_id}
              </p>
            )}
          </div>

          <div className='flex flex-col gap-2'>
            <Text>Marka</Text>
            <Select
              placeholder='Marka'
              items={brands}
              selected={selectedBrand}
              onChange={(brand) => { setSelectedBrand(brand); form.setData("model_id", undefined)}}
              onClear={() => { setSelectedBrand(undefined); form.setData("model_id", undefined)}}
              item={(item) => ({
                value: item.id,
                text: item.name,
              })}
              clearable
            />
          </div>

          <div className="flex flex-col gap-2">
            <Text color='muted'>Model</Text>
            <Select
              placeholder='Model'
              items={brandModels}
              selected={form.data.model_id}
              onChange={(model) => form.setData("model_id", model)}
              onClear={() => form.setData("model_id", undefined)}
              item={(item) => ({
                value: item.id,
                text: item.name,
              })}
              clearable
            />
            {(errors?.model_id || form.errors.model_id) && (
              <p className="text-danger text-sm">
                {errors?.model_id ?? form.errors.model_id}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text color='muted'>Stan</Text>
            <Select
              placeholder='Stan'
              items={Conditions}
              selected={form.data.condition}
              onChange={(condition) => form.setData("condition", condition)}
              onClear={() => form.setData("condition", undefined)}
              item={(item) => item}
              clearable
            />
            {(errors?.condition || form.errors.condition) && (
              <p className="text-danger text-sm">
                {errors?.condition ?? form.errors.condition}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Lokalizacja</Text>
            <Input
              name="city"
              placeholder="Lokalizacja"
              value={form.data.city}
              onChange={(e) => {
                form.clearErrors("city");
                form.setData("city", e.target.value);
              }}
            />
            {(errors?.city || form.errors.city) && (
              <p className="text-danger text-sm">
                {errors?.city ?? form.errors.city}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Cena</Text>
            <NumberInput
              name="price"
              placeholder="Cena"
              float
              value={form.data.price}
              onChange={(value) => {
                form.clearErrors("price");
                form.setData("price", value ?? 0);
              }}
            />
            {(errors?.price || form.errors.price) && (
              <p className="text-danger text-sm">
                {errors?.price ?? form.errors.price}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Zdjęcie</Text>
            
            <ImageInput
              name="photo"
              value={form.data.photo}
              full
              onChange={(file) => {
                form.setData("photo", file ?? undefined);
              }}
            />

            {(errors?.photo || form.errors.photo) && (
              <p className="text-danger text-sm">
                {errors?.photo ?? form.errors.photo}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Opis</Text>
            <MultilineInput
              name="description"
              placeholder="Opis"
              value={form.data.description}
              onChange={(e) => {
                form.clearErrors("description");
                form.setData("description", e.target.value);
              }}
            />
            {(errors?.description || form.errors.description) && (
              <p className="text-danger text-sm">
                {errors?.description ?? form.errors.description}
              </p>
            )}
          </div>

          <div className="flex justify-end items-center">
            <div className="flex gap-2">
              <NavButton href="/" text="Anuluj" disabled={form.processing} />
              <ButtonPrimary
                text="Dodaj"
                loading={form.processing}
                onClick={submit}
              />
            </div>
          </div>
        </Form>
      </Panel>
    </div>
  );
}
