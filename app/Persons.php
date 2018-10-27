<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vibrant\Vibrant\Traits\Tablable;

class Persons extends Model
{
    use Tablable;

    protected $fillable = ['id','tytuł', 'imię', 'nazwisko','status', 'email', 'telefon', 'pokój', 'grupa', 'accepted', 'komórka', 'created_at', 'updated_at'];

    public static $building_options = ['Biuro ds. nauki i wsp. z zagranicą', 'Biuro ds. ogólnych', 'Biuro ds. studenckich', 'brak', 'Dziekanat', 'Pracownia Genetyki Molekularnej i Wirusologii', 'Sekcja administracyjno-finansowa', 'Wydz.Biochemii, Biofiz. i Biotechnologii', 'Zakład Biochemii Analitycznej', 'Zakład Biochemii Fizycznej', 'Zakład Biochemii Komórki', 'Zakład Biochemii Ogólnej', 'Zakład Biochemii Porównawczej i Bioanalityki', 'Zakład Biofizyki', 'Zakład Biofizyki Komórki', 'Zakład Biofizyki Molekularnej', 'Zakład Biofizyki Obliczeniowej i Bioinformatyki', 'Zakład Biologii Komórki', 'Zakład Biotechnologii Medycznej', 'Zakład Biotechnologii Roślin', 'Zakład Fizjologii i Biochemii Roślin', 'Zakład Fizjologii i Biologii Rozwoju Roślin', 'Zakład Immunologii', 'Zakład Mikrobiologii', 'Zespół techniczny']; //Lista zakładów
    public static $title_options = ['-','mgr', 'mgr inż.', 'dr', 'dr inż.', 'dr hab.', 'prof. dr hab.']; // tytuły
    public static $status_options = ['brak', 'doktorant', 'adiunkt', 'asystent', 'asystent naukowy', 'prac. Administracyjny', 'pracownik inżynieryjno-techniczny', 'profesor emerytowany', 'profesor nadzwyczajny', 'profesor zwyczajny', 'referent techniczny', 'samodzielny biolog', 'samodzielny chemik', 'samodzielny referent techniczny', 'spec. naukowo-techniczny', 'specjalista biolog', 'specjalista informatyk', 'specjalista inż.-techn', 'specjalista inżynieryjno-techniczny', 'st. specjalista naukowo-techniczny', 'starszy referent inż-tech.', 'starszy specjalista', 'starszy specjalista inż-techniczny', 'starszy wykładowca']; // status
    public static $rules = [
        'imię' => 'required',
        'nazwisko' => 'required',
        'grupa' => 'required'
    ];

    protected $available_fields = ['tytuł', 'imię', 'nazwisko','status', 'email', 'telefon', 'pokój', 'grupa','accepted', 'komórka', 'created_at', 'updated_at'];
    protected $searchable_fields = ['tytuł', 'imię', 'nazwisko','status', 'email', 'telefon', 'pokój', 'grupa', 'komórka'];
    protected $unsortable_fields = ['telefon', 'komórka'];
    protected $hidden_fields = ['id', 'created_at', 'updated_at'];

    public function __construct()
    {
        $this->form_fields['grupa']['items'] = self::getBuildingOptions();
        $this->form_fields['tytuł']['items'] = self::getTitleOptions();
        $this->form_fields['status']['items'] = self::getStatusOptions();
        parent::__construct();
    }

    public function tableFilters()
    {
        $filters['grupa'] = self::$building_options;
        $filters['tytuł'] = self::$building_options;
        $filters['accepted'] = ['yes', 'no'];
        return ($filters);
    }

    public static function getBuildingOptions()
    {
        $options = [];
        foreach (self::$building_options as $item) {
            $options[] = ['label' => $item, 'value' => $item];
        }
        return $options;
    }


    public static function getTitleOptions()
    {
        $options = [];
        foreach (self::$title_options as $item) {
            $options[] = ['label' => $item, 'value' => $item];
        }
        return $options;
    }

    public static function getStatusOptions()
    {
        $options = [];
        foreach (self::$status_options as $item) {
            $options[] = ['label' => $item, 'value' => $item];
        }
        return $options;
    }

    public $form_fields = [
        'tytuł' => ['row' => 'new', 'col_class' => 'col-sm-2','input' => 'select',
            'items' => []
            ],
        'status' => ['row' => 'same', 'col_class' => 'col-sm-2','input' => 'select',
            'items' => []
        ],
        'imię' => ['row' => 'same', 'col_class' => 'col-sm-4', 'required' => true],
        'nazwisko' => ['row' => 'same', 'col_class' => 'col-sm-4', 'required' => true],

        'email' => ['row' => 'new', 'input' => 'email', 'col_class' => 'col-sm-3'],
        'telefon' => ['row' => 'same', 'col_class' => 'col-sm-3'],
        'komórka' => ['row' => 'same', 'col_class' => 'col-sm-3'],
        'pokój' => ['row' => 'same', 'col_class' => 'col-sm-3'],
        'grupa' => ['row' => 'new', 'col_class' => 'col-sm-6','required' => true, 'input' => 'select',
            'items' => []
        ]
    ];


}

