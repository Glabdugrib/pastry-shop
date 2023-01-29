$(document).ready(function () {

   // $("#form-dessert").submit(function (e) {
   //    e.preventDefault();
   // });

   // $("#form-dessert").find('button[type="submit"]').click(function() {
   //    console.log("clicked");
   //    console.log($("#form-dessert"))
   //    console.log( $("#form-dessert").submit() );
   // });

   $i = 0;
   $('#add-ingredient').click(function () {

      ingredientItem = document.createElement('li');
      $(ingredientItem).attr('id', 'ingredient-' + ++$i)
         .addClass('ingredient-item mb-4')
         .appendTo($("#ingredient-list"));

      row = document.createElement('div');
      $(row).addClass('row')
         .appendTo($(ingredientItem));

      inputWrapper = document.createElement('div');
      $(inputWrapper).addClass('col d-flex flex-column gap-2')
         .appendTo($(row));

      nameInput = document.createElement('input');
      $(nameInput).attr('type', 'text')
         .attr('id', 'ingredient-name-' + $i)
         .addClass('form-control')
         .attr('name', 'Dessert[ingredients][' + $i + '][name]')
         .attr('placeholder', 'Insert ingredient name')
         .appendTo($(inputWrapper));

      quantityInput = document.createElement('input');
      $(quantityInput).attr('type', 'number')
         .attr('id', 'ingredient-quantity-' + $i)
         .addClass('form-control')
         .attr('name', 'Dessert[ingredients][' + $i + '][quantity]')
         .attr('placeholder', 'Insert quantity')
         .attr('min', '0.001')
         .attr('step', '0.001')
         .appendTo($(inputWrapper));

      measureUnitInput = document.createElement('input');
      $(measureUnitInput).attr('type', 'text')
         .attr('id', 'measure-unit-' + $i)
         .addClass('form-control')
         .attr('name', 'Dessert[ingredients][' + $i + '][measure_unit]')
         .attr('placeholder', 'Insert measure unit')
         .appendTo($(inputWrapper));

      buttonWrapper = document.createElement('div');
      $(buttonWrapper).addClass('col-auto d-flex align-items-center')
         .appendTo($(row));

      deleteBtn = document.createElement('button');
      $(deleteBtn).addClass('btn btn-icon btn-danger')
         .appendTo($(buttonWrapper))
         .click(function () {
            $(this).closest('.ingredient-item').remove();
         });

      deleteIcon = document.createElement('i');
      $(deleteIcon).addClass('ti ti-trash')
      .appendTo($(deleteBtn));
   });

});