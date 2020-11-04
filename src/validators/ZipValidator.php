<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\validators;

use Yii;

class ZipValidator extends \yii\validators\RegularExpressionValidator
{
    const DEFAULT_ISO = '*';

    public $pattern = '/.+/ui';

    /**
     * Model attribute which contains country code in ISO format
     *
     * @var string $isoAttribute
     */
    public string $isoAttribute = 'country';

    public string $iso;

    public bool $useModel = true;

    /**
     * List of ZIP codes patterns from http://i18napis.appspot.com
     *
     * @var array $patterns
     * <code>
     *  $patterns = [];
     *  $data = json_decode(file_get_contents('http://i18napis.appspot.com/address/data'), true);
     *  $countries = explode('~', $data['countries']);
     *  foreach ($countries as $country) {
     *      $data = json_decode(file_get_contents('http://i18napis.appspot.com/address/data/'.$country), true);
     *      if (!empty($data['zip'])) {
     *          $patterns[strtolower($country)] = $data['zip'];
     *      }
     *  }
     *  ksort($patterns);
     *  var_export($patterns);
     * </code>
     */
    protected array $patterns = [
        'ac' => 'ASCN 1ZZ',
        'ad' => 'AD[1-7]0\d',
        'af' => '\d{4}',
        'ai' => '(?:AI-)?2640',
        'al' => '\d{4}',
        'am' => '(?:37)?\d{4}',
        'ar' => '((?:[A-HJ-NP-Z])?\d{4})([A-Z]{3})?',
        'as' => '(96799)(?:[ \-](\d{4}))?',
        'at' => '\d{4}',
        'au' => '\d{4}',
        'ax' => '22\d{3}',
        'az' => '\d{4}',
        'ba' => '\d{5}',
        'bb' => 'BB\d{5}',
        'bd' => '\d{4}',
        'be' => '\d{4}',
        'bg' => '\d{4}',
        'bh' => '(?:\d|1[0-2])\d{2}',
        'bl' => '9[78][01]\d{2}',
        'bm' => '[A-Z]{2} ?[A-Z0-9]{2}',
        'bn' => '[A-Z]{2} ?\d{4}',
        'br' => '\d{5}-?\d{3}',
        'bt' => '\d{5}',
        'by' => '\d{6}',
        'ca' => '[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJ-NPRSTV-Z] ?\d[ABCEGHJ-NPRSTV-Z]\d',
        'cc' => '6799',
        'ch' => '\d{4}',
        'cl' => '\d{7}',
        'cn' => '\d{6}',
        'co' => '\d{6}',
        'cr' => '\d{4,5}|\d{3}-\d{4}',
        'cv' => '\d{4}',
        'cx' => '6798',
        'cy' => '\d{4}',
        'cz' => '\d{3} ?\d{2}',
        'de' => '\d{5}',
        'dk' => '\d{4}',
        'do' => '\d{5}',
        'dz' => '\d{5}',
        'ec' => '\d{6}',
        'ee' => '\d{5}',
        'eg' => '\d{5}',
        'eh' => '\d{5}',
        'es' => '\d{5}',
        'et' => '\d{4}',
        'fi' => '\d{5}',
        'fk' => 'FIQQ 1ZZ',
        'fm' => '(9694[1-4])(?:[ \-](\d{4}))?',
        'fo' => '\d{3}',
        'fr' => '\d{2} ?\d{3}',
        'gb' => 'GIR ?0AA|(?:(?:AB|AL|B|BA|BB|BD|BH|BL|BN|BR|BS|BT|BX|CA|CB|CF|CH|CM|CO|CR|CT|CV|CW|DA|DD|DE|DG|DH|DL|DN|DT|DY|E|EC|EH|EN|EX|FK|FY|G|GL|GY|GU|HA|HD|HG|HP|HR|HS|HU|HX|IG|IM|IP|IV|JE|KA|KT|KW|KY|L|LA|LD|LE|LL|LN|LS|LU|M|ME|MK|ML|N|NE|NG|NN|NP|NR|NW|OL|OX|PA|PE|PH|PL|PO|PR|RG|RH|RM|S|SA|SE|SG|SK|SL|SM|SN|SO|SP|SR|SS|ST|SW|SY|TA|TD|TF|TN|TQ|TR|TS|TW|UB|W|WA|WC|WD|WF|WN|WR|WS|WV|YO|ZE)(?:\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}))|BFPO ?\d{1,4}',
        'ge' => '\d{4}',
        'gf' => '9[78]3\d{2}',
        'gg' => 'GY\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}',
        'gi' => 'GX11 1AA',
        'gl' => '39\d{2}',
        'gn' => '\d{3}',
        'gp' => '9[78][01]\d{2}',
        'gr' => '\d{3} ?\d{2}',
        'gs' => 'SIQQ 1ZZ',
        'gt' => '\d{5}',
        'gu' => '(969(?:[12]\d|3[12]))(?:[ \-](\d{4}))?',
        'gw' => '\d{4}',
        'hm' => '\d{4}',
        'hn' => '\d{5}',
        'hr' => '\d{5}',
        'ht' => '\d{4}',
        'hu' => '\d{4}',
        'id' => '\d{5}',
        'ie' => '[\dA-Z]{3} ?[\dA-Z]{4}',
        'il' => '\d{5}(?:\d{2})?',
        'im' => 'IM\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}',
        'in' => '\d{6}',
        'io' => 'BBND 1ZZ',
        'iq' => '\d{5}',
        'ir' => '\d{5}-?\d{5}',
        'is' => '\d{3}',
        'it' => '\d{5}',
        'je' => 'JE\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}',
        'jo' => '\d{5}',
        'jp' => '\d{3}-?\d{4}',
        'ke' => '\d{5}',
        'kg' => '\d{6}',
        'kh' => '\d{5}',
        'kr' => '\d{5}',
        'kw' => '\d{5}',
        'ky' => 'KY\d-\d{4}',
        'kz' => '\d{6}',
        'la' => '\d{5}',
        'lb' => '(?:\d{4})(?: ?(?:\d{4}))?',
        'li' => '948[5-9]|949[0-7]',
        'lk' => '\d{5}',
        'lr' => '\d{4}',
        'ls' => '\d{3}',
        'lt' => '\d{5}',
        'lu' => '\d{4}',
        'lv' => 'LV-\d{4}',
        'ma' => '\d{5}',
        'mc' => '980\d{2}',
        'md' => '\d{4}',
        'me' => '8\d{4}',
        'mf' => '9[78][01]\d{2}',
        'mg' => '\d{3}',
        'mh' => '(969[67]\d)(?:[ \-](\d{4}))?',
        'mk' => '\d{4}',
        'mm' => '\d{5}',
        'mn' => '\d{5}',
        'mp' => '(9695[012])(?:[ \-](\d{4}))?',
        'mq' => '9[78]2\d{2}',
        'mt' => '[A-Z]{3} ?\d{2,4}',
        'mu' => '\d{3}(?:\d{2}|[A-Z]{2}\d{3})',
        'mv' => '\d{5}',
        'mx' => '\d{5}',
        'my' => '\d{5}',
        'mz' => '\d{4}',
        'nc' => '988\d{2}',
        'ne' => '\d{4}',
        'nf' => '2899',
        'ng' => '\d{6}',
        'ni' => '\d{5}',
        'nl' => '\d{4} ?[A-Z]{2}',
        'no' => '\d{4}',
        'np' => '\d{5}',
        'nz' => '\d{4}',
        'om' => '(?:PC )?\d{3}',
        'pe' => '(?:LIMA \d{1,2}|CALLAO 0?\d)|[0-2]\d{4}',
        'pf' => '987\d{2}',
        'pg' => '\d{3}',
        'ph' => '\d{4}',
        'pk' => '\d{5}',
        'pl' => '\d{2}-\d{3}',
        'pm' => '9[78]5\d{2}',
        'pn' => 'PCRN 1ZZ',
        'pr' => '(00[679]\d{2})(?:[ \-](\d{4}))?',
        'pt' => '\d{4}-\d{3}',
        'pw' => '(969(?:39|40))(?:[ \-](\d{4}))?',
        'py' => '\d{4}',
        're' => '9[78]4\d{2}',
        'ro' => '\d{6}',
        'rs' => '\d{5,6}',
        'ru' => '\d{6}',
        'sa' => '\d{5}',
        'se' => '\d{3} ?\d{2}',
        'sg' => '\d{6}',
        'sh' => '(?:ASCN|STHL) 1ZZ',
        'si' => '\d{4}',
        'sj' => '\d{4}',
        'sk' => '\d{3} ?\d{2}',
        'sm' => '4789\d',
        'sn' => '\d{5}',
        'so' => '[A-Z]{2} ?\d{5}',
        'sv' => 'CP [1-3][1-7][0-2]\d',
        'sz' => '[HLMS]\d{3}',
        'ta' => 'TDCU 1ZZ',
        'tc' => 'TKCA 1ZZ',
        'th' => '\d{5}',
        'tj' => '\d{6}',
        'tm' => '\d{6}',
        'tn' => '\d{4}',
        'tr' => '\d{5}',
        'tw' => '\d{3}(?:\d{2})?',
        'tz' => '\d{4,5}',
        'ua' => '\d{5}',
        'um' => '96898',
        'us' => '(\d{5})(?:[ \-](\d{4}))?',
        'uy' => '\d{5}',
        'uz' => '\d{6}',
        'va' => '00120',
        'vc' => 'VC\d{4}',
        've' => '\d{4}',
        'vg' => 'VG\d{4}',
        'vi' => '(008(?:(?:[0-4]\d)|(?:5[01])))(?:[ \-](\d{4}))?',
        'vn' => '\d{6}',
        'wf' => '986\d{2}',
        'xk' => '[1-7]\d{4}',
        'yt' => '976\d{2}',
        'za' => '\d{4}',
        'zm' => '\d{5}',
        '*' => '[A-Z0-9-]{1,}'
    ];

    /** {@inheritdoc} */
    public function init()
    {
        parent::init();
        $this->message = Yii::t("hipanel", "{attribute} does not support country");

    }

    /** {@inheritdoc} */
    public function validateAttribute($model, $attribute)
    {
        if ($this->useModel !== true) {
            if (empty($this->iso)) {
                throw new \Exception(Yii::t("hipanel", "ISO code must be setted"));
            }
        } else {
            $data = $model->getAttributes();
            $this->iso = empty($data[$this->isoAttribute]) ? self::DEFAULT_ISO : $data[$this->isoAttribute];
        }

        $this->pattern = $this->preparePattern();

        $value = strtoupper($model->$attribute);
        $result = $this->validateValue($value);

        if (!empty($result)) {
            $this->addError($model, $attribute, $result[0], $result[1]);
        }
    }

    /**
     * Prepare validator pattern
     */
    private function preparePattern() : string
    {
        $this->iso = strtolower($this->iso);
        $iso = empty($this->patterns[$this->iso]) ? self::DEFAULT_ISO : $this->iso;

        return "/^" . $this->patterns[$iso] . "$/u";
    }
}

