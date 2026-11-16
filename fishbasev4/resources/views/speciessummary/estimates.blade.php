@php
$data = [];

if (isset($speciessummary['Estimates']) && is_array($speciessummary['Estimates']) && count($speciessummary['Estimates'])) {
   //preftemp
   if (
      isset($speciessummary['Estimates']['Preftemp']) && 
      is_array($speciessummary['Estimates']['Preftemp']) &&
      count($speciessummary['Estimates']['Preftemp']) &&
      isset($speciessummary['Estimates']['Preftemp']['TempPrefMean']) &&
      !is_null($speciessummary['Estimates']['Preftemp']['TempPrefMean'])
   ) {
      $preftemp = $speciessummary['Estimates']['Preftemp'];
      $tmp = 'Preferred temperature (Ref. 123201): '.$preftemp['TempPrefMin'].' - '.$preftemp['TempPrefMax'].', mean '.$preftemp['TempPrefMean'].' &deg;C (based on '.$preftemp['nCells'].' cells).';
      $data[] = $tmp;
   }
   
   // phylogenetic
   if (
      isset($speciessummary['Estimates']['getPD50']) && 
      !is_null($speciessummary['Estimates']['getPD50'])
   ) {
      $tmp = 'Phylogenetic diversity index (Ref. 82804): PD<sub>50</sub> = '.$speciessummary['Estimates']['getPD50'].'  [Uniqueness, from 0.5 = low to 2.0 = high].';
      $data[] = $tmp;
   }

   // bayesian
   if (
      isset($speciessummary['Estimates']['Bayesian']) && 
      is_array($speciessummary['Estimates']['Bayesian']) &&
      count($speciessummary['Estimates']['Bayesian'])
   ) {
      $tmp = 'Bayesian length-weight: ';
      $bayesian = $speciessummary['Estimates']['Bayesian'];
      $estA1 = pow(10,log10($bayesian['a'])-(1.96*$bayesian['sd_log10a']));
      $estA2 = pow(10,log10($bayesian['a'])+(1.96*$bayesian['sd_log10a']));
      $estB1 = (($bayesian['b'])-(1.96*$bayesian['sd_b']));
      $estB2 = (($bayesian['b'])+(1.96*$bayesian['sd_b']));
      $tmp .= 'a=' . number_format($bayesian['a'], 5) . ' (' . number_format($estA1, 5) . ' - ' . number_format($estA2, 5) . '), ';
      $tmp .= 'b=' . number_format($bayesian['b'], 2) . ' (' . number_format($estB1, 2) . ' - ' . number_format($estB2, 2) . '), ';
      $tmp .= 'in cm total length, based on '.$bayesian['Method_ab'].' (Ref. 93245).';
      $data[] = $tmp;
   }

   // trophiclevel
   if (
      isset($speciessummary['Estimates']['TrophicLevel']) && 
      is_array($speciessummary['Estimates']['TrophicLevel']) &&
      count($speciessummary['Estimates']['TrophicLevel'])
   ) {
      $tl = $speciessummary['Estimates']['TrophicLevel'];
      $tmp = false;
      if (empty($tl['FoodTroph']) && empty($tl['DietTroph']) && ($tl['seTroph'] != 0 && number_format($tl['Troph'], 1) == 0 ))  {
         $tmp = number_format($tl['Troph'], 1).' &plusmn;'.number_format($tl['seTroph'], 1).' se; ';
         $tmp .= 'Based on size and trophs of closest relatives.';
      }
      elseif (!empty($tl['DietTroph']) || $tl['DietTroph'] != "") {
         $tmp = number_format($tl['DietTroph'], 1).' &plusmn;'.number_format($tl['DietSeTroph'], 1).' se; ';
         $tmp .= 'Based on diet studies.';
      }
      elseif (!empty($tl['FoodTroph']) || $tl['FoodTroph'] != "") {
         $tmp = number_format($tl['FoodTroph'], 1).' &plusmn;'.number_format($tl['FoodSeTroph'], 1).' se; ';
         $tmp .= 'Based on food items.';
      }

      if ($tmp) {
         $tmp = 'Trophic level (Ref. 69278): '.$tmp;
         $data[] = $tmp;
      }
   }
   //Generation time
   //var_dump($speciessummary['Estimates']['RegenerationTime']);
   if(isset($speciessummary['Estimates']['RegenerationTime']))

   if ( $speciessummary['Estimates']['RegenerationTime']['Median_T'] != NULL ){
         if($speciessummary['Estimates']['RegenerationTime']['n_T'] > 3){
            $tmp = " Generation time: " . number_format($speciessummary['Estimates']['RegenerationTime']['Median_T'], 1) . " (" . number_format($speciessummary['Estimates']['RegenerationTime']['lcl_T'], 1)  . " - " . number_format($speciessummary['Estimates']['RegenerationTime']['ucl_T'], 1)  . ") years. Estimated as median ln(3)/K based on " .  $speciessummary['Estimates']['RegenerationTime']['n_T'] . "<a href='/popdyn/PopGrowthList.php?ID=" . $speciessummary['Estimates']['RegenerationTime']['SpecCode'] . "&fc=" . number_format($speciessummary['Estimates']['RegenerationTime']['FamCode']) . "'> growth studies.</a>";}
         else{
            $tmp = " Generation time: " . number_format($speciessummary['Estimates']['RegenerationTime']['Median_T'], 1) . " ( na - na) years. Estimated as median ln(3)/K based on " .  $speciessummary['Estimates']['RegenerationTime']['n_T'] . "<a href='/popdyn/PopGrowthList.php?ID=" . $speciessummary['Estimates']['RegenerationTime']['SpecCode'] . "'> growth studies.</a>";
         }
      $data[] = $tmp;
   }
   // resilience
   if (
      isset($speciessummary['Estimates']['Resilience']) && 
      is_array($speciessummary['Estimates']['Resilience']) &&
      count($speciessummary['Estimates']['Resilience']) &&
      isset($speciessummary['Estimates']['Resilience']['resilience']) && 
      !is_null($speciessummary['Estimates']['Resilience']['resilience'])
   ) {

      $resiliences =  [
         'High' => 'minimum population doubling time less than 15 months',
         'Medium' => 'minimum population doubling time 1.4 - 4.4 years',
         'Low'      => 'minimum population doubling time 4.5 - 14 years',
         'Very low'  => 'minimum population doubling time more than 14 years'
      ];

      $tmp = 'Resilience (Ref. 120179): ';
      $tmp .= $speciessummary['Estimates']['Resilience']['resilience'].', '.$resiliences[$speciessummary['Estimates']['Resilience']['resilience']].' ('.$speciessummary['Estimates']['Resilience']['resilienceremark'].')';
      $data[] = $tmp.'.';
   }

   // prior r
   if (
      isset($speciessummary['Estimates']['PriorR']) && 
      is_array($speciessummary['Estimates']['PriorR']) &&
      count($speciessummary['Estimates']['PriorR']) &&
      isset($speciessummary['Estimates']['PriorR']['prior_r']) && 
      !is_null($speciessummary['Estimates']['PriorR']['prior_r'])
   ) {

      $tmp = 'Prior r = ';
      $tmp .= number_format($speciessummary['Estimates']['PriorR']['prior_r'], 2).', ';
      $tmp .= '95% CL = '.number_format($speciessummary['Estimates']['PriorR']['lcl_r'], 2).' - '.number_format($speciessummary['Estimates']['PriorR']['ucl_r'], 2).', ';
      $tmp .= $speciessummary['Estimates']['PriorR']['comment_r'];
      $data[] = $tmp;
   }
   //Fishing Vulnerability
   
   // vulnerability
   if (
      isset($speciessummary['Estimates']['Vulnerability']) && 
      is_array($speciessummary['Estimates']['Vulnerability']) &&
      count($speciessummary['Estimates']['Vulnerability']) &&
      isset($speciessummary['Estimates']['Vulnerability']['vulnerability']) && 
      !is_null($speciessummary['Estimates']['Vulnerability']['vulnerability'])
   ) {

      $vuln = 'Very high vulnerability';
      $vulval = $speciessummary['Estimates']['Vulnerability']['vulnerability'];
      $vulns = [
         'Low vulnerability' => [-1, 25],
         'Low to moderate vulnerability' => [25, 35],
         'Moderate vulnerability' => [35, 45],
         'Moderate to high vulnerability' => [45, 55],
         'High vulnerability' => [55, 65],
         'High to very high vulnerability' => [65, 75],
      ];

      array_filter($vulns, function($val, $key) use(&$vuln, $vulval) {
         if ($vulval > $val[0] && $vulval <= $val[1]) {
            $vuln = $key;
            return;
         }
      }, ARRAY_FILTER_USE_BOTH);

      $tmp = 'Fishing vulnerability (Ref. 59153): ';
      $tmp .= $vuln.' ('.number_format($vulval)." of 100).";
      $data[] = $tmp;
   }
   //Climate Vulnerability
   if (
      isset($speciessummary['Estimates']['Vulnerability']) && 
      is_array($speciessummary['Estimates']['Vulnerability']) &&
      count($speciessummary['Estimates']['Vulnerability']) &&
      isset($speciessummary['Estimates']['Vulnerability']['VulnerabilityClimate']) && 
      !is_null($speciessummary['Estimates']['Vulnerability']['VulnerabilityClimate'])
   ) {

      $vuln = 'Very high vulnerability';
      $vulval = $speciessummary['Estimates']['Vulnerability']['VulnerabilityClimate'];
      $vulns = [
         'Low vulnerability' => [-1, 25],
         'Low to moderate vulnerability' => [25, 35],
         'Moderate vulnerability' => [35, 45],
         'Moderate to high vulnerability' => [45, 55],
         'High vulnerability' => [55, 65],
         'High to very high vulnerability' => [65, 75],
      ];

      array_filter($vulns, function($val, $key) use(&$vuln, $vulval) {
         if ($vulval > $val[0] && $vulval <= $val[1]) {
            $vuln = $key;
            return;
         }
      }, ARRAY_FILTER_USE_BOTH);

      $tmp = 'Climate vulnerability (Ref. 125649): ';
      $tmp .= $vuln.' ('.number_format($vulval)." of 100).";
      $data[] = $tmp;
   }
   // price
   if (
      isset($speciessummary['Species']['Importance']) && 
      $speciessummary['Species']['Importance'] &&
      !is_null($speciessummary['Species']['Importance']) && 
      $speciessummary['Species']['Importance'] !== 'of no interest' &&
      isset($speciessummary['Estimates']['PriceCategory']) && 
      is_array($speciessummary['Estimates']['PriceCategory']) &&
      count($speciessummary['Estimates']['PriceCategory']) &&
      isset($speciessummary['Estimates']['PriceCategory']['pricecateg']) && 
      !is_null($speciessummary['Estimates']['PriceCategory']['pricecateg'])
   ) {
      $tmp = 'Price category (Ref. 80766): ';
      $tmp .= ucfirst($speciessummary['Estimates']['PriceCategory']['pricecateg']);
      if (isset($speciessummary['Estimates']['PriceCategory']['pricereliability']) && $speciessummary['Estimates']['PriceCategory']['pricereliability']) {
         $tmp .= '; '.$speciessummary['Estimates']['PriceCategory']['pricereliability'];
      }
      $data[] = $tmp.'.';
   }
   $NutrientsArray = $speciessummary['Estimates']['Nutrients'];
    foreach($NutrientsArray As $NutrientsItem){
         if($NutrientsItem == NULL){$NoneNutrientsItem = true;}
         else{$NoneNutrientsItem = false;}
   }
  
   if($NoneNutrientsItem == false){
      
      //$EstimatesNutrientsArray = implode(" ", $speciessummary['EstimatesNutrients']);
      //var_dump($speciessummary['Estimates']['Nutrients']);

         if (isset($speciessummary['EstimatesNutrients']['Calcium'])) {
            $Nutrientsdata = "Calcium = " . $speciessummary['EstimatesNutrients']['Calcium'] . " [" . $speciessummary['EstimatesNutrients']['Calcium_l95']  .", ". $speciessummary['EstimatesNutrients']['Calcium_u95'] . "] mg/100g";
         }
         if (isset($speciessummary['EstimatesNutrients']['Iron'])) {
            $Nutrientsdata .= "; Iron = " . $speciessummary['EstimatesNutrients']['Iron'] . " [" . $speciessummary['EstimatesNutrients']['Iron_l95']  .", ". $speciessummary['EstimatesNutrients']['Iron_u95'] . "] mg/100g";
         }
         if (isset($speciessummary['EstimatesNutrients']['Protein'])) {
            $Nutrientsdata .= "; Protein = " . $speciessummary['EstimatesNutrients']['Protein'] . " [" . $speciessummary['EstimatesNutrients']['Protein_l95']  .", ". $speciessummary['EstimatesNutrients']['Protein_u95']. "] %";
         }
         if (isset($speciessummary['EstimatesNutrients']['Omega3'])) {
            $Nutrientsdata .= "; Omega3 = " . $speciessummary['EstimatesNutrients']['Omega3'] . " [" . $speciessummary['EstimatesNutrients']['Omega3_l95']  .", ". $speciessummary['EstimatesNutrients']['Omega3_u95']. "] g/100g";
         }
         if (isset($speciessummary['EstimatesNutrients']['Selenium'])) {
            $Nutrientsdata .= "; Selenium = " . $speciessummary['EstimatesNutrients']['Selenium'] . " [" . $speciessummary['EstimatesNutrients']['Selenium_l95']  .", ". $speciessummary['EstimatesNutrients']['Selenium_u95']. "] μg/100g";
         }
         if (isset($speciessummary['EstimatesNutrients']['VitaminA'])) {
            $Nutrientsdata .= "; VitaminA = " . $speciessummary['EstimatesNutrients']['VitaminA'] . " [" . $speciessummary['EstimatesNutrients']['VitaminA_l95']  .", ". $speciessummary['EstimatesNutrients']['VitaminA_u95'] . "] μg/100g";
         }
         if (isset($speciessummary['EstimatesNutrients']['Zinc'])) {
            if($speciessummary['Estimates']['Nutrients']['NutrientRefNo'] == NULL) {
               $Nutrientsdata .= "; Zinc = " . $speciessummary['EstimatesNutrients']['Zinc'] . " [" . $speciessummary['EstimatesNutrients']['Zinc_l95']  .", ". $speciessummary['EstimatesNutrients']['Zinc_u95']. "] mg/100g (wet weight); ";
            } else {
            $Nutrientsdata .= "; Zinc = " . $speciessummary['EstimatesNutrients']['Zinc'] . " [" . $speciessummary['EstimatesNutrients']['Zinc_l95']  .", ". $speciessummary['EstimatesNutrients']['Zinc_u95']. "] mg/100g (wet weight); based on "; 
            $Nutrientsdata .= "<a href='/Nutrients/NutrientsList.php?speccode=" . $speciessummary['Estimates']['RegenerationTime']['SpecCode'] . "&GenusName=" . $speciessummary['Estimates']['Nutrients']['GenusUsed'] . "&SpeciesName=" . $speciessummary['Estimates']['Nutrients']['SpeciesUsed'] . "' target='_blank'>nutrient studies</a>.";
            //../Nutrients/NutrientsList.php?speccode=" . $speciessummary['EstimatesNutrients']['estimate.Speccode'] . "&GenusName=" . //$speciessummary['EstimatesNutrients']['estimate.genus'] . "&SpeciesName=" $speciessummary['EstimatesNutrients']['estimate.species'] . "
            }
         }
      $tmp = 'Nutrients (Ref. 124155): ';
      $tmp .= $Nutrientsdata;
   }
   $data[] = $tmp;
}
@endphp
@if(count($data))

@push('page-link')
<li>
        <a href="#estimates" data-summary-open="#estimates">Estimates based on models</a>
</li>
@endpush

<details id="estimates">
                    <summary><div>
                        <div class="title">Estimates based on models</div>
                        <div class="arrow">
                            <svg class="icon small middle">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </div>
		</summary>
                <div>
                <p>
                {!! FishBase::text(join('</p><p>',$data)) !!}
                </p>
                </div>
</details>
@endif
{{-- 
<br><br>
<b>Estimates based on models</b><br>
   
   Phylogenetic diversity index :<br>
   Bayesian length-weight:<br>
   LWR estimates for this body shape<br>
   Trophic Level <br>
   Resilience<br>
   Vulnerability <br>

   	<br><br>
--}}

	