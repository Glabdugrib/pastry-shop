$(document).ready(function () {

   $i = 0;
   $('#add-ingredient').click(function () {

      ingredientItem = document.createElement('li');
      $(ingredientItem).addClass('ingredient-item mb-4')
         .appendTo($("#ingredient-list"));

      row = document.createElement('div');
      $(row).addClass('row')
         .appendTo($(ingredientItem));

      inputWrapper = document.createElement('div');
      $(inputWrapper).addClass('col d-flex flex-column gap-2')
         .appendTo($(row));

      nameInput = document.createElement('input');
      $(nameInput).attr('type', 'text')
         .addClass('form-control')
         .attr('name', 'Dessert[ingredients][N' + ++$i + '][name]')
         .attr('placeholder', 'Insert ingredient name')
         .appendTo($(inputWrapper));

      quantityInput = document.createElement('input');
      $(quantityInput).attr('type', 'number')
         .addClass('form-control')
         .attr('name', 'Dessert[ingredients][N' + $i + '][quantity]')
         .attr('placeholder', 'Insert quantity')
         .attr('min', '0.01')
         .attr('step', '0.01')
         .appendTo($(inputWrapper));

      measureUnitInput = document.createElement('input');
      $(measureUnitInput).attr('type', 'text')
         .addClass('form-control')
         .attr('name', 'Dessert[ingredients][N' + $i + '][measure_unit]')
         .attr('placeholder', 'Insert measure unit')
         .appendTo($(inputWrapper));

      buttonWrapper = document.createElement('div');
      $(buttonWrapper).addClass('col-auto d-flex align-items-center')
         .appendTo($(row));

      deleteBtn = document.createElement('button');
      $(deleteBtn).addClass('delete-ingredient btn btn-icon btn-outline-danger')
         .appendTo($(buttonWrapper))
         .click(function () {
            $(this).closest('.ingredient-item').remove();
         });

      deleteIcon = document.createElement('i');
      $(deleteIcon).addClass('ti ti-trash')
      .appendTo($(deleteBtn));
   });

   $('.delete-ingredient').each(function() {
      $(this).click(function() {
         $(this).closest('.ingredient-item').remove();
      });
   });

});