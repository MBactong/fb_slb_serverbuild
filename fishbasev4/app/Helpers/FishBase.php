<?php 
namespace App\Helpers;

class FishBase
{
    
    const DOMAIN = 'localhost';

    static function text($string)
    {
        // fix invalid HTML
        $pattern = ["/".preg_quote("<i/>", "/")."/i"];
        $replace = ["</i>"];
        $s = preg_replace($pattern, $replace, $string);
        
        // parse reference
        $s = preg_replace_callback(
            "/Refs?\.?\s*([0-9,\sRef\.]+)/",
            function($matches) {
                $links = [];
                $refs = preg_split("/[,\s]/", $matches[1]);
                foreach($refs as $ref) {
                    $ref = preg_replace("/[Ref\.]+/i", '', $ref);
                    if (trim($ref)) {
                        //$links[] = '<a href="/reference/'. urlencode($ref) .'">'.$ref.'</a>';
                        $links[] = '<a href="/references/FBRefSummary.php?ID='.urlencode($ref) .'" title="Reference '.$ref.'">'.$ref.'</a>';
                    }
                } 
                return 'Ref. '.join(', ', $links);
            },
            $s
        );
        return $s;
    }

    static function formatWeight($weight) {
        if($weight < 1000) {
            $weight = number_format($weight, 2);
            return $weight.' g';
        }
        if($weight >= 1000 && $weight < 1000000) {
            $weight = $weight/1000;
            $weight = number_format($weight, 1);
            return $weight.' kg';
        }
        if($weight >= 1000000) {
            $weight = $weight/1000000;
            $weight = number_format($weight, 1);
            return $weight.' t';
        }
        return $weigth;
    }

    static function IUCN($iucnCode) {
        If ($iucnCode == "EX")          { $status = "Extinct";}
        elseif ($iucnCode == "EW")      { $status = "Extinct in the Wild"; }
        elseif ($iucnCode == "CR")      { $status = "Critically Endangered"; }
        elseif ($iucnCode == "EN")      { $status = "Endangered"; }
        elseif ($iucnCode == "VU")      { $status = "Vulnerable"; }
        elseif ($iucnCode == "LR")      { $status = "Lower Risk"; }
        elseif ($iucnCode == "LR/cd")   { $status = "Lower Risk: conservation dependent"; }
        elseif ($iucnCode == "LR/nt")   { $status = "Lower Risk: near threatened"; }
        elseif ($iucnCode == "LR/lc")   { $status = "Lower Risk: least concern"; }
        elseif ($iucnCode == "DD")      { $status = "Data deficient"; }
        elseif ($iucnCode == "NL")      { $status = "Not in IUCN Red List"; }
        elseif ($iucnCode == "N.E.")    { $status = "Not Evaluated"; }
        elseif ($iucnCode == "N.A.")    { $status = "Not Applicable"; }
        elseif ($iucnCode == "LC")      { $status = "Least Concern"; }
        elseif ($iucnCode == "NT")      { $status = "Near Threatened"; }
        else { $status = ""; }

        return $status.(($iucnCode != 'N.E.' && $iucnCode != 'N.A.') ? ' ('.$iucnCode.')' : '');
    }

    static function trafficLight($code) {
        $mark = 'none';
        $marks = [
            'danger' => [
                'EX',
                'EW',
                'CR',
                'EN',
                'VU',
                'NT',
                'poisonous to eat',
                'reports of ciguatera poisoning',
                'venomous',
                'traumatogenic',
            ],
            'warn' => [
                'DD',
                'potential pest',
            ],
            'ok' => [
                'LC',
                'LR',
                'LR/cd',
                'LR/nt',
                'LR/lc',
                'harmless',
            ]
        ];
        
        switch(true) {
            case (in_array($code, $marks['ok'])):
                $mark = 'ok';
                break;
            case (in_array($code, $marks['warn'])):
                $mark = 'warn';
                break;
            case (in_array($code, $marks['danger'])):
                $mark = 'danger';
                break;
        }
        return '<span class="mark '.$mark.'" data-code="'.$code.'">&nbsp;</span>';
    }

    static function vulnerabiltytext(){}


    static function sigFig($value, $digits){
        if ($value == 0) {
        $decimalPlaces = $digits - 1;
        } elseif ($value < 0) {
        $decimalPlaces = $digits - floor(log10($value * - 1)) - 1;
        } else {
        $decimalPlaces = $digits - floor(log10($value)) - 1;
        }

        $answer = round($value, $decimalPlaces);
        return $answer;
    }//end of  static function sigFig

    static function setDecimalPlace($med, $value){
        if(strlen(substr(strrchr($med, "."), 1)) == 0) return number_format($value, 0);
        else if(strlen(substr(strrchr($med, "."), 1)) == 1) return number_format($value, 1);
        else if(strlen(substr(strrchr($med, "."), 1)) == 2) return number_format($value, 2);
        else if(strlen(substr(strrchr($med, "."), 1)) == 3) return number_format($value, 3);
    }

    static function links($speciesdata, $link, $linktext, $moreinfo = false) {
        if (!$moreinfo) {
            return $linktext;
        }
        $species = $speciesdata['Species']['Species'];
        $genus = $speciesdata['Species']['Genus'];
        $speccode = $speciesdata['Species']['SpecCode'];
        $famcode = $speciesdata['Species']['FamCode'];
        $syncode = null;
        try {
            $stockcode = ($speciesdata['Morphology']['StockCode'] || $speciesdata['Distribution']['StockCode'] ? ($speciesdata['Morphology']['StockCode'] ? $speciesdata['Morphology']['StockCode'] : $speciesdata['Distribution']['StockCode']) : null);
        }
        catch(\Exception $e) {
            $stockcode = null;
        }
        
        $links = [
            'ecology_lnk'           => "/Ecology/FishEcologySummary.php?StockCode=$stockcode&GenusName=$genus&SpeciesName=".urlencode($species),
            'diet_lnk'              => "/TrophicEco/DietCompoList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) .  "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'fooditems_lnk'         => "/TrophicEco/FoodItemsList.php?vstockcode=" . $stockcode . "&genus=" . $genus . "&species=" . urlencode($species),
            'foodconsumption_lnk'   => "/TrophicEco/FoodConsumptionList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'ration_lnk'            => "/TrophicEco/RationList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'metabolism_lnk'        => "/physiology/OxygenDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'predators_lnk'         => "/TrophicEco/PredatorList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'ecotoxicology_lnk'     => "/physiology/CL50List.php?ID=" . $speccode,
            'commonnames_lnk'       => "/ComNames/CommonNamesList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&StockCode=" . $stockcode,
            'synonyms_lnk'          => "/Nomenclature/SynonymsList.php?ID=" . $speccode . "&SynCode=" . $syncode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'reproduction_lnk'      => "/Reproduction/FishReproSummary.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'maturity_lnk'          => "/Reproduction/MaturityList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,
            'spawning_lnk'          => "/Reproduction/SpawningList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'spawnaggregation_lnk'  => "/Reproduction/SpawningAggregationList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'fecundity_lnk'         => "/Reproduction/FecundityList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'eggs_lnk'              => "/Reproduction/FishEggInfoSummary.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'eggsdev_lnk'           => "/Reproduction/FishEggDevList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&StockCode=" . $stockcode,
            'larvae_lnk'            => "/Reproduction/LarvaeInfoList.php?ID=".$speccode."&GenusName=" . $genus . "&SpeciesName=" . urlencode($species)."&stockcode=".$stockcode,
            'larvaldynamics_lnk'    => "/Reproduction/LarvaeDynaSummary.php?GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&StockCode=" . $stockcode . "&ID=".$speccode,
            'recruitment_lnk'       => "/Recruitment/RecruitmentList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'abundance_lnk'         => "/Abundance/AbundanceList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'agesize_lnk'           => "/popdyn/PopCharList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,
            'growth_lnk'            => "/popdyn/PopGrowthList.php?ID=" . $speccode . "&GenusName=" . urlencode($genus) . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode,
            'lw_lnk'                => "/popdyn/LWRelationshipList.php?ID=" . $speccode . "&GenusName=" . urlencode($genus) . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode,
            'll_lnk'                => "/popdyn/LLRelationshipList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,
            'lf_lnk'                => "/popdyn/LengthFreqList.php?ID=" . $speccode,
            'morphometrics_lnk'     => "/physiology/MorphMetList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'morphology_lnk'        => "/physiology/MorphDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'aquaculture_lnk'       => "/Aquaculture/AquacultureList.php?ID=" . $speccode,
            'aquacultureprof_lnk'   => "/Aquaculture/AquacultureProfileSummary.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'strains_lnk'           => "/physiology/StrainList.php?ID=" . $speccode,
            'genetics_lnk'          => "/Genetics/FishGeneticsList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'allelefreq_lnk'        => "/Genetics/FishElecStudiesList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'heritability_lnk'      => "/Genetics/PopCharList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'diseases_lnk'          => "/diseases/DiseasesList.php?ID=" . $speccode . "&StockCode=" . $stockcode,
            'processing_lnk'        => "/Aquaculture/ProcessingList.php?speccode=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'massConversion_lnk'    => "/summary/biomass.php?id=" . $speccode,
            'sounds_lnk'            => "/physiology/FishSoundsList.php?id=" . $speccode,
            'ciguatera_lnk'         => "/country/CiguateraPoisoningList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'speed_lnk'             => "/physiology/SpeedList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'swimtype_lnk'          => "/physiology/SwimModeList.php?ID=" . $speccode,
            'gillarea_lnk'          => "/physiology/GillAreaDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'otoliths_lnk'          => "/physiology/OtolithsSummary.php?speccode=" . $speccode,
            'brains_lnk'            => "/physiology/BrainsDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,
            'vision_lnk'            => "/physiology/VisionList.php?id=" . $speccode,

            'countries_lnk'         => "/country/CountryList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'faoareas_lnk'          => "/country/FaoAreaList.php?ID=" . $speccode . "&GenusName=" . urlencode($genus) . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode . "&StockCode=" . $stockcode . "&Scientific=" . urlencode($genus) . "+" .urlencode($species),
            'ecosystems_lnk'        => "/TrophicEco/EcosysList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'occurrences_lnk'       => "/museum/OccurrencesList.php?genus=$genus&species=" . urlencode($species),
            'introductions_lnk'     => "/introductions/IntroductionsList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode . "&StockCode=" . $stockcode,
            'stocks_lnk'            => "/summary/stocks/StocksDefinition.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&StockCode=" . $stockcode,

            'references_lnk'        => "/references/SummaryRefList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),
            'collaborators_lnk'     => "/Collaborators/CollaboratorsList.php?ID=" . $speccode . "&Genus=" . urlencode($genus) . "&Species=" . urlencode($species),
            
            'pictures_lnk'          => "/photos/ThumbnailsSummary.php?Genus=". urlencode($genus) ."&Species=". urlencode($species),
            'stamps_lnk'            => "/photos/SpeciesStampsList.php?speccode=" . $speccode,
            
        ];

        if (isset($links[$link])) {
            return '<a href="'. $links[$link] .'" target="_blank">'.$linktext.'</a>';
        }
        return $linktext;
        /*
        function moreInfoDisplayLink($famcode, $order)
{
        global $speccode, $stockcode, $genus, $species, $fr_url, $cgnet_url, $rde_url, $fbname, $detail_figis_id, $saup_id, $detail_rfeid, $detail_classname, $detail_DF24,$tw_url, $syncode, $tm_for_kf, $itis;

                $itis = getITISCode($speccode);
                $syncode = getSynonymsCode($speccode, $genus, $species);

                $moreInfoLnkNames = array(

                        'googleimage_lnk' => "https://www.google.com/images?hl=en&q=".$genus."+".urlencode($species)."&btnG=Search+Images&gbv=2",

                        'col_lnk' => "http://www.catalogueoflife.org/col/search/all/key/{$genus}+" . urlencode($species) . "/match/1",

                        'itis_lnk' => "http://www.itis.gov/servlet/SingleRpt/SingleRpt?search_topic=TSN&search_value=".$itis,

                        //More Information 1st column
                        'ecology_lnk' => "../Ecology/FishEcologySummary.php?StockCode=$stockcode&GenusName=$genus&SpeciesName=".urlencode($species),

                        'diet_lnk'      => "/TrophicEco/DietCompoList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) .  "&fc=" . $famcode . "&StockCode=" . $stockcode ,

                        'fooditems_lnk' => "../TrophicEco/FoodItemsList.php?vstockcode=" . $stockcode . "&genus=" . $genus . "&species=" . urlencode($species),

                        'foodconsumption_lnk' => "../TrophicEco/FoodConsumptionList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'ration_lnk' => "../TrophicEco/RationList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'metabolism_lnk' => "../physiology/OxygenDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'predators_lnk' => "../TrophicEco/PredatorList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'ecotoxicology_lnk' => "../Physiology/CL50List.php?ID=" . $speccode,

                        //More Information 2nd column
                        'commonnames_lnk' => "/ComNames/CommonNamesList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&StockCode=" . $stockcode,

                        'synonyms_lnk' => "../Nomenclature/SynonymsList.php?ID=" . $speccode . "&SynCode=" . $syncode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'reproduction_lnk' => "../Reproduction/FishReproSummary.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'maturity_lnk' => "/Reproduction/MaturityList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,

                        'spawning_lnk' => "/Reproduction/SpawningList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'fecundity_lnk' => "/Reproduction/FecundityList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'eggs_lnk' => "../Reproduction/FishEggInfoSummary.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'eggsdev_lnk' => "../Reproduction/FishEggDevList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&StockCode=" . $stockcode,

                        //Begin MOD 05/25/2017 Shelumiel Ortiz
                        //'larvae_lnk' => "../larvalbase/Reproduction/LarvaeInfoList.php?ID=".$speccode."&GenusName=" . $genus . "&SpeciesName=" . urlencode($species)."&stockcode=".$stockcode,

                        'larvae_lnk' => "../Reproduction/LarvaeInfoList.php?ID=".$speccode."&GenusName=" . $genus . "&SpeciesName=" . urlencode($species)."&stockcode=".$stockcode,
                        //END MOD 05/25/2017 Shelumiel Ortiz

                        'larvaldynamics_lnk' => "../Reproduction/LarvaeDynaSummary.php?GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&StockCode=" . $stockcode . "&ID=".$speccode,

                        'recruitment_lnk' => "/Recruitment/RecruitmentList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'abundance_lnk' => "../Abundance/AbundanceList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        //More Information 3rd column
                         'agesize_lnk' => "/popdyn/PopCharList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,

                        'growth_lnk' => "/popdyn/PopGrowthList.php?ID=" . $speccode . "&GenusName=" . urlencode($genus) . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode,

                        'lw_lnk' => "/popdyn/LWRelationshipList.php?ID=" . $speccode . "&GenusName=" . urlencode($genus) . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode,

                        'll_lnk' => "../popdyn/LLRelationshipList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,

                        'lf_lnk' => "../popdyn/LengthFreqList.php?ID=" . $speccode,

                        'morphometrics_lnk' => "../physiology/MorphMetList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'morphology_lnk' => "../physiology/MorphDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        //More Information 4th column
                        'aquaculture_lnk' => "../Aquaculture/AquacultureList.php?ID=" . $speccode,

                        'aquacultureprof_lnk' => "../Aquaculture/AquacultureProfileSummary.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'strains_lnk' => "../physiology/strainlist.php?ID=" . $speccode,

                        'genetics_lnk' => "../Genetics/FishGeneticsList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'allelefreq_lnk' => "../Genetics/FishElecStudiesList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'heritability_lnk' => "../Genetics/PopCharList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'diseases_lnk' => "../Diseases/DiseasesList.php?ID=" . $speccode . "&StockCode=" . $stockcode,

                        'processing_lnk' => "../Aquaculture/ProcessingList.php?speccode=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'massConversion_lnk' => "../summary/biomass.php?id=" . $speccode,

                        //More Information 5th column
                        'sounds_lnk' => "../physiology/FishSoundsList.php?id=" . $speccode,

                        'ciguatera_lnk' => "../Country/CiguateraPoisoningList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'speed_lnk' => "../Physiology/SpeedList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'swimtype_lnk' => "../physiology/SwimModeList.php?ID=" . $speccode,

                        'gillarea_lnk' => "../physiology/GillAreaDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'otoliths_lnk' => "../physiology/OtolithsSummary.php?speccode=" . $speccode,

                        'brains_lnk' => "../physiology/BrainsDataList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species). "&fc=" . $famcode,

                        'vision_lnk' => "../physiology/visionlist.php?id=" . $speccode,

                        //Distribution section

                        'countries_lnk' => "/Country/CountryList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'faoareas_lnk' => "../Country/FaoAreaList.php?ID=" . $speccode . "&GenusName=" . urlencode($genus) . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode . "&StockCode=" . $stockcode . "&Scientific=" . urlencode($genus) . "+" .urlencode($species),

                        'ecosystems_lnk' => "../trophiceco/EcosysList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'occurrences_lnk' => "../museum/OccurrencesList.php?genus=$genus&species=" . urlencode($species),

                        'introductions_lnk' => "../Introductions/IntroductionsList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&fc=" . $famcode . "&StockCode=" . $stockcode,

                        'stocks_lnk' => "../Summary/Stocks/StocksDefinition.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&StockCode=" . $stockcode,

                        //Tools section
                        'biogeomodel_lnk' => "../Map/BiogeoModellingV4.cfm?ID=" . $speccode,

                        'bioquiz_lnk' => "../FBQuiz/QuizBiodiv_main.php?speccode=". $speccode,

                        //Begin Mod 09/14/17 Shelumiel Ortiz
                        //'ebook_lnk' => "../FieldGuide/FieldGuideSummary.php?GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&pda=&sps=",
                        'ebook_lnk' => "../FieldGuide/FieldGuideSummary.php?GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&pda=1&sps=",
                        //End Mod 09/14/17 Shelumiel Ortiz

                        'fieldguide_lnk' => "../FieldGuide/FieldGuideSummary.php?GenusName=" . $genus . "&SpeciesName=" . urlencode($species) . "&sps=&print=",

                        'idkeys_lnk' => "../Keys/ListIDKeys.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        // 'lfwizard_lnk' => "http://" . $fr_url . "/report/LFAnalysis_step01.cfm?speccode=" . $speccode,
                        'lfwizard_lnk' => "../report/LFAnalysis_step01.php?speccode=" . $speccode,

                        'lifehistory1_lnk' => "/popdyn/KeyfactsSummary_1.php?ID=" . $speccode .
        "&GenusName=" . $genus .
        "&SpeciesName=" . urlencode($species) . "&vStockCode=" . $stockcode .
        "&fc=" . $famcode,

                        'lifehistory2_lnk' => "/popdyn/KeyfactsSummary_2v2.php?ID=" . $speccode .
                        "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) .
                        "&vStockCode=" . $stockcode . "&fc=" . $famcode,

                        'lifehistory3_lnk' => "/popdyn/KeyfactsSummary_3.php?ID=" . $speccode .
                                "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) .
                                "&vStockCode=" . $stockcode . "&fc=" . $famcode .
                                "&var_tm=" . $tm_for_kf,

                        'lifehistory4_lnk' => "/popdyn/KeyfactsSummary_4.php?ID=" . $speccode .
                                "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species) .
                                "&vStockCode=" . $stockcode . "&fc=" . $famcode .
                                "&var_tmax=" . $tm_for_kf,

                        'pointdata_lnk' => "../Map/OccurrenceMapList.php?genus=$genus&species=" . urlencode($species) ,

                        'lifemapper_lnk' => "javascript:document.forms.fn_lifemapper.submit()",

                        'catch_msy_lnk' => "http://{$cgnet_url}/CatchMSY/intro.php?genus={$genus}&species={$species}",
                        //classification
                        'class_lnk' => "" ,

                        'order_lnk' => "/summary/OrdersSummary.php?order=".$order ,

                        'family_lnk' => "/summary/FamilySummary.php?ID=".$famcode ,

                        // fishwatcher
                        'fishwatcher_lnk'       => "https://" . $cgnet_url . "/FishWatcher/checkpassword.php?Genus=" . $genus . "&Species=" . urlencode($species) . "&vtable=contribution_a",

                        //add your site
                        'addsite_lnk' => "https://" . $cgnet_url . "/FishWatcher/url_addform.php?speccode=" . $speccode,

                        //upload photo, video, stamps, attach website
                        'photos_lnk' => "https://$cgnet_url/tools/UploadPhoto/start.php?speccode=$speccode",

                        'videos_lnk' => "https://$cgnet_url/tools/UploadVideo/start_info.php?speccode=$speccode",
                        'stamps_lnk' => "../photos/SpeciesStampsList.php?speccode=" . $speccode,

                        'allpics_lnk' => "../photos/thumbnailssummary.php?Genus=".$genus."&Species=".$species,
                        'attach_lnk'  => "https://$cgnet_url/FishWatcher/url_addform.php?speccode=$speccode",
                        //special reports
                        // changed the link to us server as PH is not available indefinitely
                        'cfam_lnk'      => "/Aquaculture/AquamaintList.php?speccode=" . $speccode . "&fbx=&rde=",
                        'cfsfs_lnk' => "/summary/FactSheetList.php?speccode=" . $speccode . "&src=1",
                        'cfafs_lnk' => "/summary/FactSheetList.php?speccode=" . $speccode . "&src=2",

                        //internet sources - deep links
                        'aidb_lnk' => "../Database/AlienInvasiveList.php?ID=" . $speccode,

                        'boldsys_lnk' => "http://www.barcodinglife.org/views/taxbrowser.php?taxon=" . $genus . "+" . urlencode($species),

                        'cisti_lnk' => "https://cat.cisti.nrc.ca/search/Y?SEARCH=" . $genus . "+" . urlencode($species),

                        'discoverlife_lnk' => "http://www.discoverlife.org/20/q?search=" . $genus . "+" . urlencode($species) . "&b=FB" . $speccode,

                        'ecotox_lnk' => "javascript:document.forms.fn_ecotox.submit()",

                        'faoaqua_lnk' => "../report/FAO/FAOAquacultureList.php?scientific=" . urlencode(checkFAOLinks($speccode, 'Stats_Aquaculture')),

                         'faocatch_lnk' => "../report/FAO/FAOCatchList.php?scientific=" . urlencode(checkFAOLinks($speccode, 'Stats_Catch')),

                         'googlebooks_lnk' => "https://books.google.com/books?ie=UTF-8&q=%22" . $genus . "+" . urlencode($species) . "%22 OR %22" . urlencode($fbname) . "%22&btnG=Search",

                         'googlescholar_lnk' => "https://scholar.google.com/scholar?q=%22" . $genus . "+" . urlencode($species) . "%22 OR %22" . urlencode($fbname) ."%22&ie=UTF-8&oe=UTF-8&hl=en&btnG=Search",

                         'google_lnk' => "https://www.google.com/search?q=%22" . $genus . "+" . urlencode($species) . "%22+%22" . urlencode($fbname) . "%22&time=7&x=44&y=7",

                         'gobase_lnk' => "javascript:document.forms.fn_gobase.submit()",

                         'faospecies_lnk' => "//www.fao.org/fishery/species/". $detail_figis_id,

                         'genome_lnk' => "https://www.ncbi.nlm.nih.gov/genome/?term=".$genus."+".urlencode($species)."%5Borgn%5D&report=docsum",

                         'nucleotide_lnk' => "https://www.ncbi.nlm.nih.gov/nuccore/?term=".$genus."+".urlencode($species)."%5Borgn%5D&report=docsum",

                        'ispecies_lnk' => "http://darwin.zoology.gla.ac.uk/~rpage/ispecies/?q=$genus+" . urlencode($species) . "&submit=Go",


                        //internet sources - other links
                        //Begin Mod 04/19/17 Shelumiel Ortiz
                        //'bhl_lnk' => "http://www.biodiversitylibrary.org/name/$genus+".urlencode($species),
                        'bhl_lnk' => "http://www.biodiversitylibrary.org/search?SearchTerm=$genus+".urlencode($species) . "#/names",
                        //End Mod 04/19/17 Shelumiel Ortiz

                        'nationaldb_lnk' => "../Topic/NatDBaseList.php?ID=" . $speccode . "&fbGenus=" . $genus. "&fbSpecies=" . urlencode($species) . "&LDB=",

                        'publicaqua_lnk' => "../report/ShowAquariumList.php?speccode=" . $speccode,

                        //Begin ADD 03/03/2017 Shelumiel Ortiz
                        'mitofish_lnk' => "http://mitofish.aori.u-tokyo.ac.jp/species/result.html?q=$genus+".urlencode($species),
                        //End ADD 03/03/2017 Shelumiel Ortiz

                        'pubmed_lnk' => "https://www.ncbi.nlm.nih.gov/entrez/query.fcgi?CMD=search&DB=pubmed&term="  . $genus . "+" . urlencode($species),

                        'saup_lnk' => "http://www.seaaroundus.org/data/#/taxa/" . $saup_id,


                        'slb_lnk' => "HTTP://www.sealifebase.org/NomenClature/ScientificNameSearchList.php?crit1_fieldname=SYNONYMS.SynGenus&crit1_fieldtype=CHAR&crit2_fieldname=SYNONYMS.SynSpecies&crit2_fieldtype=CHAR&crit1_operator=EQUAL&crit2_operator=EQUAL&crit1_value=$genus&crit2_value=" . urlencode($species),

                        'scirus_lnk' => "http://www.scirus.com/search_simple/?frm=simple&query_1=%22" . $genus . "+" . urlencode($species) . "%22+%22" . $fbname . "%22&wordtype_1=all&dsweb=on&dsmem=on&hits=10",

                        'rfeid_lnk' => "http://www.cfsan.fda.gov/~frf/rfe0" . trim($detail_rfeid) . ".html",

                         'tol_lnk' => "http://tolweb.org/tree?group=". substr($detail_classname, 0, strpos($detail_classname, " ")),

                        'ubio_lnk' => "http://portal.ubio.org/index.php?tnsnav=lists&searchtype=web&map=&start=0&search=" . urlencode($genus . " " . urlencode($species)),

                        'ubiorss_lnk' => "javascript:document.forms.nodeform.submit()",

                        'wikigo_lnk' => "https://en.wikipedia.org/wiki/Special:Search?search=" . urlencode($genus . " " . urlencode($species)) . "&go=Go",

                        'wikisearch_lnk' => "https://en.wikipedia.org/wiki/Special:Search?search=" . urlencode($genus . " " . urlencode($species)) . "&fulltext=Search",

                        'zoorec_lnk' => "http://www.organismnames.com/query.htm?q=$genus+" . urlencode($species) . "&Submit.x=20&Submit.y=7&searchType=simple&so=a0",

                        'uwebsite_lnk' => "https://$cgnet_url/FishWatcher/SpeciesURLList.php?speccode=$speccode",

                        'ufishwatcher_lnk' => "https://$cgnet_url/FishWatcher/CollectionsList.php?speccode=$speccode&what=Species",

                        'fishtrace_lnk' => "https://fishtrace.jrc.ec.europa.eu/web/fishtrace/dataviz/dna",


                        //MENUS
                        'references_lnk' =>"/References/SummaryRefList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'biblio_lnk' => "../Biblio/BiblioSummaryList.php?ID=" . $speccode . "&GenusName=" . $genus . "&SpeciesName=" . urlencode($species),

                        'coordinator_lnk' => "../Collaborators/CollaboratorSummary.cfm?ID=" . $detail_DF24,

                        'collaborators_lnk' => "/Collaborators/CollaboratorsList.php?ID=" . $speccode . "&Genus=" . urlencode($genus) . "&Species=" . urlencode($species),

                        'srchgazetteer_lnk' => 'http://middleware.alexandria.ucsb.edu/client/gaz/adl/index.jsp',

                        'websitez_lnk' => "https://" . $cgnet_url . "/FishWatcher/url_addform.php?speccode=" . $speccode,

                        'fishforum_lnk' => "https://" . $cgnet_url . "/FBForum/index.php",

                        //Begin Mod 02/21/18 Shelumiel Ortiz
                        //'getxml_lnk' => "https://" . $cgnet_url ."/webservice/summary/fb/showXML.php?identifier=FB-$speccode&ProviderDbase=03",
                        'getxml_lnk' => "../webservice/summary/fb/showXML.php?identifier=FB-$speccode&ProviderDbase=03",
                        //End Mod 02/21/18 Shelumiel Ortiz

                        'pdataxml_lnk' => "../webservice/Occurrence/PointData.php?Genus=" . $genus . "&Species=" . urlencode($species),

                        'comnamexml_lnk' => "../webservice/ComNames/comnamesxml.php?Genus=" . $genus . "&Species=" . urlencode($species),

                        'photoxml_lnk' => "../webservice/photos/FishPicsList.php?Genus=" . $genus . "&Species=" . urlencode($species) . "&type=",

                        'morecomname_lnk' => "/ComNames/CommonNamesList.php?ID=$speccode&GenusName=$genus&SpeciesName=". urlencode($species)."&StockCode=$stockcode",

                        'moresynname_lnk' => "/Nomenclature/SynonymsList.php?ID=$speccode&SynCode=$syncode&GenusName=$genus&SpeciesName=".urlencode($species),

                        //RDE
                        'add_lnk' => "http://" . $rde_url . "/remotedataentry/search/summary/AddRecord.cfm?StockCode=" . $stockcode. "&speccode=" . $speccode. "&Genus=" .$genus . "&Species=" . urlencode($species) ,

                        'update_lnk' => 'javascript:document.fn.submit()',

                        'summary_lnk' => "/summary/".$speccode,

                        );

        return $moreInfoLnkNames;
}



        */
    }
}