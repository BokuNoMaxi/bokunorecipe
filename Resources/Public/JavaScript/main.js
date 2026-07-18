if (document.getElementById("recipe-reset")) {
  document
    .getElementById("recipe-reset")
    .addEventListener("click", function (e) {
      let form = document.getElementById("bkr-searchbar");
      let checkboxes = document.querySelectorAll(
        '#bkr-searchbar input[type="checkbox"]'
      );

      form.reset();
      checkboxes.forEach(function (checkbox) {
        checkbox.checked = false;
      });
      form.submit();
    });
}

// Portion calculator: scales each ingredient's quantity against recipe.portions.
// Only rescales values that are pure numbers (regex below) - quantities like
// "2-3" or free text stay untouched rather than silently producing a wrong number.
document
  .querySelectorAll(".bokunorecipe__detail__portions")
  .forEach(function (control) {
    var input = control.querySelector("input[type=number]");
    var basePortions = parseFloat(control.dataset.basePortions);
    var section = control.closest(".bokunorecipe__detail__ingredients_section");
    if (!input || !basePortions || !section) {
      return;
    }

    var numericPattern = /^\d+([.,]\d+)?$/;
    var quantityEls = section.querySelectorAll("[data-quantity]");

    function formatQuantity(value) {
      var rounded = Math.round(value * 100) / 100;
      return rounded % 1 === 0 ? String(rounded) : rounded.toFixed(2).replace(/0+$/, "").replace(/\.$/, "");
    }

    function applyPortions() {
      var portions = parseFloat(input.value);
      if (!portions || portions <= 0) {
        return;
      }
      var ratio = portions / basePortions;
      quantityEls.forEach(function (el) {
        var raw = el.dataset.quantity.trim();
        if (!numericPattern.test(raw)) {
          return;
        }
        el.textContent = formatQuantity(parseFloat(raw.replace(",", ".")) * ratio);
      });
    }

    input.addEventListener("input", applyPortions);
    control.querySelectorAll("[data-portions-step]").forEach(function (button) {
      button.addEventListener("click", function () {
        var step = parseInt(button.dataset.portionsStep, 10);
        var current = parseFloat(input.value) || basePortions;
        input.value = Math.max(1, current + step);
        applyPortions();
      });
    });
  });
