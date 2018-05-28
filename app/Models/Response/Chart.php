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

namespace App\Models\Response;

use App\Models\Communication\Model;

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
	 * The Label of the DataSet.
	 *
	 * @required
	 *
	 * @var string
	 */
	public $label = '';

	/**
	 * The content of the Data Set.
	 *
	 * @required
     *
     * @rule chartData
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * If the content of the Lines will be filled
	 *  by the same color of the line.
	 *
	 * Options: true (start), end, origin, false (none)
	 *
	 * @var string|bool
	 */
	public $fill = 'origin';
}
