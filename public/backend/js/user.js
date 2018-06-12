//region Category name to slug
$("#name").keyup(function () {
    let str = $(this).val();
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents
    let from = "àáảãạâấậăắẳặđèéẽẻẹêếềễểệìíĩỉịòóõỏọôồốỗổộơờớỡởợùúũủụừứữửựỳýỹỷỵ·/_,:;";
    let to = "aaaaaaaaaaaadeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuyyyyy------";
    for (let i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    let slug = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    $("#slug").val(slug.toLowerCase());
});
//endregion

//region Category title to slug
$("#title").keyup(function () {
    let str = $(this).val();
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents
    let from = "àáảãạâấậăắặđèéẽẻẹêếềễểệìíĩỉịòóõỏọôồốỗổộơờớỡởợùúũủụưừứữửựỳýỹỷỵ·/_,:;";
    let to = "aaaaaaaaaaadeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyy------";
    for (let i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    let slug = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    $("#slug").val(slug.toLowerCase());
});
//endregion

//region DatePicker
$('input[name="discount_range"]').daterangepicker({
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
});

$('input[name="discount_range"]').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});

$('input[name="discount_range"]').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
});
//endregion

//region Show Product Properties Tab
let subs = $("#sl_subCategory").children('option');

function filterSubCategory(val) {
    subs.hide();
    subs.each(function (i, el) {
        if ($(el).attr('data-type') === val) {
            $(el).show();
        }
    })
}

//Before Post
$("#sl_mainCategory").change(function () {
    let filterValue = $('option:selected', this).text();

    switch (filterValue) {
        case 'Choose..':
            subs.show();
            $("#properties-nav").children().removeClass('active').children('a').removeClass('active show');
            $("#properties-tabs").children().removeClass('active show');
            break;
        case 'Mainboard':
            filterSubCategory(filterValue);
            $("#Mainboard-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#Mainboard").addClass("active show").siblings().removeClass("active show");
            break;
        case 'CPU':
            filterSubCategory(filterValue);
            $("#CPU-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#CPU").addClass("active show").siblings().removeClass("active show");
            break;
        case 'RAM':
            filterSubCategory(filterValue);
            $("#RAM-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#RAM").addClass("active show").siblings().removeClass("active show");
            break;
        case 'HDD':
            filterSubCategory(filterValue);
            $("#HDD-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#HDD").addClass("active show").siblings().removeClass("active show");
            break;
        case 'SSD':
            filterSubCategory(filterValue);
            $("#SSD-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#SSD").addClass("active show").siblings().removeClass("active show");
            break;
        case 'VGA':
            filterSubCategory(filterValue);
            $("#VGA-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#VGA").addClass("active show").siblings().removeClass("active show");
            break;
        case 'Case':
            filterSubCategory(filterValue);
            $("#Case-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#Case").addClass("active show").siblings().removeClass("active show");
            break;
        case 'PSU':
            filterSubCategory(filterValue);
            $("#PSU-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#PSU").addClass("active show").siblings().removeClass("active show");
            break;
        case 'Monitor':
            filterSubCategory(filterValue);
            $("#Monitor-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
            $("#Monitor").addClass("active show").siblings().removeClass("active show");
            break;
    }
});

//After Post
let filterValue = $('option:selected', '#sl_mainCategory').text();

switch (filterValue) {
    case 'Choose..':
        subs.show();
        $("#properties-nav").children().removeClass('active').children('a').removeClass('active show');
        $("#properties-tabs").children().removeClass('active show');
        break;
    case 'Mainboard':
        filterSubCategory(filterValue);
        $("#Mainboard-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#Mainboard").addClass("active show").siblings().removeClass("active show");
        break;
    case 'CPU':
        filterSubCategory(filterValue);
        $("#CPU-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#CPU").addClass("active show").siblings().removeClass("active show");
        break;
    case 'RAM':
        filterSubCategory(filterValue);
        $("#RAM-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#RAM").addClass("active show").siblings().removeClass("active show");
        break;
    case 'HDD':
        filterSubCategory(filterValue);
        $("#HDD-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#HDD").addClass("active show").siblings().removeClass("active show");
        break;
    case 'SSD':
        filterSubCategory(filterValue);
        $("#SSD-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#SSD").addClass("active show").siblings().removeClass("active show");
        break;
    case 'VGA':
        filterSubCategory(filterValue);
        $("#VGA-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#VGA").addClass("active show").siblings().removeClass("active show");
        break;
    case 'Case':
        filterSubCategory(filterValue);
        $("#Case-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#Case").addClass("active show").siblings().removeClass("active show");
        break;
    case 'PSU':
        filterSubCategory(filterValue);
        $("#PSU-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#PSU").addClass("active show").siblings().removeClass("active show");
        break;
    case 'Monitor':
        filterSubCategory(filterValue);
        $("#Monitor-tab a").addClass("active show").parent().siblings().children().removeClass("active show");
        $("#Monitor").addClass("active show").siblings().removeClass("active show");
        break;
}

//endregion

//region Show file name after selecting image to upload

$("#product_thumbnail, #product_img_1, #product_img_2, #product_img_3").on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    fileName.length > 30 ? fileName = fileName.substr(0, 10) + '..' : fileName;
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
//endregion

//region Owl Carousel
$("#current-product-images").owlCarousel({
    loop:true,
    margin:10,
    items:1,
    autoplay:true
});
//endregion
