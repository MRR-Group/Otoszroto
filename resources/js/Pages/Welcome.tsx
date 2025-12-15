import { Button } from '@/Components/Button';
import { ButtonPrimary } from '@/Components/ButtonPrimary';
import { Input } from '@/Components/Input';
import { Panel } from '@/Components/Panel';
import { Select } from '@/Components/Select';
import { Tag } from '@/Components/Tag';
import { Text } from '@/Components/Text';
import { Title } from '@/Components/Title';
import { useMessageBox } from '@/Hooks/UseMessageBox';
import React from 'react';

export function Welcome() {
    const [category, setCategory] = React.useState<string>('engine');
    const { confirm } = useMessageBox();

    const categories = [
        { id: 'engine', name: 'Silnik' },
        { id: 'brakes', name: 'Hamulce' },
        { id: 'suspension', name: 'Zawieszenie' },
        { id: 'electronics', name: 'Elektryka' },
    ];


    async function handleDelete() {
        const ok = await confirm({
            title: "Usuń ofertę",
            message: "Czy na pewno chcesz usunąć tę ofertę?",
            confirmText: "Usuń",
            danger: true,
        });

        if (ok) {
            console.log("usunięto");
        }
    };

    return (
        <div className='p-4'>
            <Panel>
                <Title type='h1'>OtoSzroto — Styleguide i komponenty UI</Title>
                <Text>Ten dokument prezentuje żywe przykłady komponentów i opisuje użyte tokeny kolorów. Został zbudowany jako osobny plik HTML — można go otworzyć samodzielnie i służy jako referencja dla implementacji UI.</Text>
            </Panel>

            <Panel className='mt-5'>
                <Title>Przyciski</Title>
                <Text>Warianty przycisków i ich kolory.</Text>

                <div className='flex gap-5 mt-3'>
                    <Button disabled text='Neutralny (disabled)' />
                    <Button text='Neutralny' />
                    <Button loading text='Neutralny' />
                </div>
            </Panel>

            <Panel className='mt-5'>
                <Title>Przyciski</Title>

                <Text>Warianty przycisków i ich kolory.</Text>

                <div className='flex gap-5 mt-3'>
                    <ButtonPrimary disabled text='Neutralny (disabled)' />
                    <ButtonPrimary text='Neutralny' />
                    <ButtonPrimary loading text='Neutralny' />
                </div>
            </Panel>

            <Panel className='mt-5'>
                <Title>Chipsy</Title>
                <Text>Małe znaczniki informacyjne. </Text>

                <div className='flex gap-5 mt-3'>
                    <Tag>Filtry intuicyjne</Tag>
                    <Tag>Kategoryzacja</Tag>
                    <Tag>Kontakt</Tag>
                </div>
            </Panel>

            <Panel className='mt-5'>
                <Title>Inputy</Title>
                <Text>Wszystkie pola wejściowe mają ciemne tło i jasny tekst.</Text>

                <div className='flex gap-5 mt-3'>
                    <Input placeholder='np. alternator' />
                    
                    <Select
                        items={categories}
                        selected={category}
                        onChange={setCategory}
                        item={(item) => ({
                            value: item.id,
                            text: item.name,
                        })}
                    />
                </div>
            </Panel>


            <Panel className='mt-5'>
                <Title>MessageBox</Title>
                <Text>Lorem, ipsum dolor sit amet consectetur</Text>
                
                <div className='p-4'>
                    <ButtonPrimary text='Delete' onClick={handleDelete} />
                </div>
            
            </Panel>
        </div>
    );
}
