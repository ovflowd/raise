<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Models\Communication;

/**
 * Class Chart.
 *
 * A Chart Model it's a Data Set for
 *  ChartJS Library
 *
 * @see http://www.chartjs.org/
 * @see http://www.chartjs.org/docs/latest/
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Chart extends Model
{
    /**
     * The Label of the DataSet
     *
     * @required
     *
     * @var string
     */
    public $label = '';

    /**
     * The content of the Data Set
     *
     * @required
     *
     * @var array
     */
    public $data = [];

    /**
     * Iterate between an Data Set of Data Documents
     *  and rearrange it to the Chart.JS Data Document pattern
     *
     * @param array $data the Data Set to be Hooked
     */
    public function setData(array $data)
    {
        $temporary = [];

        foreach ($data as $value)
            $temporary[date('Y-m-d', $value->document->clientTime)]++;

        foreach($temporary as $date => $amount)
            $this->data[] = ['x' => $date, 'y' => $amount];
    }

    /**
     * If the content of the Lines will be filled
     *  by the same color of the line
     *
     * @var bool
     */
    public $fill = true;
}
