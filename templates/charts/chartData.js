/**
 * Created by awt on 17/01/2017.
 */

/**
 *
 * @param type Pie chart or doughnut etc
 * @param labels Labels/Legend
 * @param data Values of the data
 * @param bgcolor A colour for the data
 * @param hoverbgcolor A highlight colour for the data
 * @returns {{type: *, data: {labels: *, datasets: [*]}, options: {responsive: boolean}}}
 */
function x(type, labels, data, bgcolor)
{
    return {
        type: type,
            data: {
        labels: labels,
            datasets: [
            {
                data: data,
                backgroundColor: bgcolor,
                hoverBackgroundColor: bgcolor
            }]
    }
    ,
        options: {
            responsive: false
        }
    };
}