<?php

use App\Models\Maps\Maps;
use App\Models\Production\Production;
use LaravelIdea\Helper\App\Models\Production\_IH_Production_C;

function mapsDBSection()
{
    return Maps::where('id', auth()->user()->projectMapID())->first();
}

function productionDBSection($id): _IH_Production_C|array|Production
{
    return Production::findOrFail($id);
}

function saatgut()
{
    $seeds = [];
    $md_fruitTypes = json_decode(mapsDBSection()->md_fruitTypes, true, 512, JSON_THROW_ON_ERROR);

    foreach ($md_fruitTypes['fruitTypes'] as $index => $fruitType) {
        if (! empty($fruitType['fruitType']['windrow'])) {
            $seeds[strtoupper($index)] = [
                'name' => $fruitType['name'],
                'seedUsagePerSqm' => $fruitType['fruitType']['cultivation']['seedUsagePerSqm'],
                'literPerSqm' => $fruitType['fruitType']['harvest']['literPerSqm'],
                'windrowName' => $fruitType['fruitType']['windrow']['name'],
                'litersPerSqm' => $fruitType['fruitType']['windrow']['litersPerSqm'],
            ];
        } else {
            $seeds[strtoupper($index)] = [
                'name' => $fruitType['name'],
                'seedUsagePerSqm' => $fruitType['fruitType']['cultivation']['seedUsagePerSqm'],
                'literPerSqm' => $fruitType['fruitType']['harvest']['literPerSqm'],
            ];
        }
    }

    return $seeds;
}

function fertilizer()
{
    $sprayType = [];
    $md_sprayType = json_decode(mapsDBSection()->md_sprayTypes, true, 512, JSON_THROW_ON_ERROR);
    foreach ($md_sprayType as $sprayTypes) {
        if (! empty($sprayTypes['sprayGroundType'])) {
            $sprayType[$sprayTypes['name']] = [
                'name' => $sprayTypes['name'],
                'litersPerSecond' => $sprayTypes['litersPerSecond'],
                'type' => $sprayTypes['type'],
                'sprayGroundType' => $sprayTypes['sprayGroundType'],
            ];
        } else {
            $sprayType[$sprayTypes['name']] = [
                'name' => $sprayTypes['name'],
                'litersPerSecond' => $sprayTypes['litersPerSecond'],
                'type' => $sprayTypes['type'],
            ];
        }
    }

    return $sprayType;
}

function maps()
{
    return Maps::findOrFail(auth()->user()->projectMapID());
}

function fillTypes()
{
    $md_fillTypes = json_decode(mapsDBSection()->md_fillTypes, true, 512, JSON_THROW_ON_ERROR);

    return $md_fillTypes['fillTypes'];
}

/**
 * @throws JsonException
 */
function externFillType($id)
{
    if (productionDBSection($id)->fillType) {
        $md_fillTypes = json_decode(mapsDBSection()->md_fillTypes, true, 512, JSON_THROW_ON_ERROR);
        $production = json_decode(productionDBSection($id)->fillType, true, 512, JSON_THROW_ON_ERROR);

        return array_merge($production['fillTypes'], $md_fillTypes['fillTypes']);
    }

    $md_fillTypes = json_decode(mapsDBSection()->md_fillTypes, true, 512, JSON_THROW_ON_ERROR);

    return $md_fillTypes['fillTypes'];
}

function inflation($fillType, $month)
{
    return fillTypes()[$fillType]['factors'][$month]['value'];
}

function seedsPrice()
{
    return fillTypes()['SEEDS']['pricePerLiter'];
}

function seedsCalcRate($seeds, $hektar)
{
    $seed = strtoupper($seeds);
    $seedsVolume = (saatgut()[$seed]['seedUsagePerSqm'] * 10000) * (float) $hektar;
    $priceSeed = $seedsVolume * seedsPrice();

    return [
        'seedsVolume' => $seedsVolume,
        'priceSeed' => $priceSeed,
    ];
}

function fertilizerCalcRate($fertilizer, $hektar, $month = 0)
{
    $fertilizer = strtoupper($fertilizer);
    $fertilizerVolumen = (fertilizer()[$fertilizer]['litersPerSecond'] * 36000) * $hektar;
    $priceFertilizer = $fertilizerVolumen * fillTypes()[$fertilizer]['pricePerLiter'];

    return [
        'fertilizerVolumen' => $fertilizerVolumen,
        'priceFertilizer' => $priceFertilizer,
    ];
}

function increaseInValue($valueCommodities, $products): string
{
    if (! empty($valueCommodities) and ! empty($products)) {
        return number_format(($products / $valueCommodities - 1) * 100, 2, ',', '.').' %';
    }

    return number_format(0, 2, ',', '.').' %';
}

function multiplier($valueCommodities, $products): string
{
    if (! empty($valueCommodities) and ! empty($products)) {
        return number_format(1 + ((($products / $valueCommodities - 1) * 100) / 100), 2, ',', '.');
    }

    return number_format(0, 2, ',', '.');
}

function productionsDB($id)
{
    $produktionen = Production::findOrFail($id);
    $productionChooseName = $produktionen->name;

    return [
        'id' => $produktionen['id'],
        'production' => json_decode($produktionen['production'], true, 512, JSON_THROW_ON_ERROR),
        'productionChooseName' => $productionChooseName,
    ];
}

/**
 * @throws JsonException
 */
function productionSelect($nameProduction, $productionChoose)
{
    $calculationNew = [];
    if (! empty($nameProduction)) {
        //        $calculationNew = [];
        $productionsData = productionsDB($productionChoose)['production'];
        $prodID = productionsDB($productionChoose)['id'];
        $productionsChoose = productionsDB($productionChoose)['productionChooseName'];
        foreach ($nameProduction as $name => $item) {
            $calculation[$item] = $productionsData[$item];
            foreach ($calculation[$item]['input'] as $inputName => $input) {
                if (! empty(externFillType($prodID)[$input['fillType']]['pricePerLiter']) and ! empty($input['fillType'])) {
                    $calculationNew[$productionsChoose][$item]['input'][$inputName] = [
                        'name' => __('production.'.strtoupper($calculation[$item]['id'])),
                        'fillTypeInput' => __('fillTypes.'.$input['fillType']),
                        'amountInput' => $calculation[$item]['cyclesPerHour'] * $input['amount'],
                        'priceInputL' => externFillType($prodID)[$input['fillType']]['pricePerLiter'],
                        'priceInput' => ($calculation[$item]['cyclesPerHour'] * $input['amount']) * externFillType($prodID)[$input['fillType']]['pricePerLiter'],
                        'fillTypeOutput' => null,
                        'amountOutput' => null,
                        'priceOutputL' => null,
                        'priceOutput' => null,
                    ];
                } else {
                    $calculationNew[$productionsChoose][$item]['input'][$inputName] = [
                        'name' => null,
                        'fillTypeInput' => 'Keine Rohstoffe',
                        'amountInput' => null,
                        'priceInputL' => null,
                        'priceInput' => null,
                        'fillTypeOutput' => null,
                        'amountOutput' => null,
                        'priceOutputL' => null,
                        'priceOutput' => null,
                    ];
                }
            }
            foreach ($calculation[$item]['output'] as $outputName => $output) {
                if (! empty(externFillType($prodID)[$output['fillType']]['pricePerLiter']) and ! empty($output['fillType'])) {
                    $calculationNew[$productionsChoose][$item]['output'][$outputName] = [
                        'name' => __('production.'.strtoupper($calculation[$item]['id'])),
                        'fillTypeOutput' => __('fillTypes.'.$output['fillType']),
                        'amountOutput' => $calculation[$item]['cyclesPerHour'] * $output['amount'],
                        'priceOutputL' => externFillType($prodID)[$output['fillType']]['pricePerLiter'],
                        'priceOutput' => ($calculation[$item]['cyclesPerHour'] * $output['amount']) * externFillType($prodID)[$output['fillType']]['pricePerLiter'],
                        'fillTypeInput' => null,
                        'amountInput' => null,
                        'priceInputL' => null,
                        'priceInput' => null,
                    ];
                } else {
                    $calculationNew[$productionsChoose][$item]['output'][$outputName] = [
                        'name' => null,
                        'fillTypeInput' => null,
                        'amountInput' => null,
                        'priceInputL' => null,
                        'priceInput' => null,
                        'fillTypeOutput' => 'wird nicht hergestellt',
                        'amountOutput' => null,
                        'priceOutputL' => null,
                        'priceOutput' => null,
                    ];
                }
            }

        }

        return $calculationNew;
    }

    return $calculationNew;
}
