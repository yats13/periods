
    /**
     * @param $sentence
     * @param int $cases
     * @return string
     */
    private function getPeriods($sentence)
    {
        $i = $sentence['sum'];
        $word = $sentence['periodName'];
        $cases = isset($sentence['periodCount']);
        $lang = Yii::$app->request->get('languageId');
        $array = Periods::find()
            ->innerJoinWith(['periodsValues' => function($query)use($lang, $cases){
                $query->andWhere(['lang_id' => $lang]);
                $query->andWhere(['cases' => $cases]);
            }])
            ->where(['Periods.name' => $word])
            ->one();
        $value = ArrayHelper::getColumn($array->periodsValues, 'value');
        $last_number = substr($i, -1);
        $last_numbers = substr($i, -2);

        if($i == 1 || ((count($value) == 3 || $lang == 1) && $last_number == 1 && $last_numbers != 11)){
            return $i ." ". current($value);
        } else if( count($value) == 3 && $last_number > 1 && $last_number < 5 && !in_array($last_numbers,range(11,20)) ) {
            return $i ." ". next($value);
        } else {
            return $i ." ". end($value);
        }
    }
    
    
