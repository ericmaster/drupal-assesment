(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.personFormAutopopulate = {
    attach: function (context, settings) {
      // Auto-populate label and machine name from first/last name fields
      var $firstNameField = $('[data-drupal-selector="edit-first-name"]', context);
      var $lastNameField = $('[data-drupal-selector="edit-last-name"]', context);

      // Check if fields exist and don't already have the event bound
      if ($firstNameField.length && $lastNameField.length && !$firstNameField.data('person-autopopulate-bound')) {

        function updateLabel() {
          var firstName = $firstNameField.val() || '';
          var lastName = $lastNameField.val() || '';
          var fullName = (firstName + ' ' + lastName).trim();

          // Update the hidden label field
          var $labelField = $('[data-person-label="true"]');
          if ($labelField.length) {
            $labelField.val(fullName).trigger('input');
          }
        }

        // Bind events to both fields
        $firstNameField.on('input.personAutopopulate', updateLabel);
        $lastNameField.on('input.personAutopopulate', updateLabel);

        // Mark as bound to prevent duplicate binding
        $firstNameField.data('person-autopopulate-bound', TRUE);
        $lastNameField.data('person-autopopulate-bound', TRUE);

        // Initial update on page load
        updateLabel();
      }
    }
  };

})(jQuery, Drupal);
