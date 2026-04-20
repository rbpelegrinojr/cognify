(function(){
  var wrap = document.getElementById('choiceWrap');
  var addBtn = document.getElementById('addChoiceBtn');

  function bindRemoveButtons(){
    var buttons = document.querySelectorAll('.remove-choice');
    for (var i = 0; i < buttons.length; i++) {
      buttons[i].onclick = function(){
        var rows = document.querySelectorAll('#choiceWrap .choice-row');
        if (rows.length <= 2) {
          alert('At least 2 choices are recommended.');
          return;
        }
        this.parentNode.parentNode.removeChild(this.parentNode);
        refreshRadioValues();
      };
    }
  }

  function refreshRadioValues(){
    var rows = document.querySelectorAll('#choiceWrap .choice-row');
    for (var i = 0; i < rows.length; i++) {
      var radio = rows[i].querySelector('input[type=radio]');
      radio.value = i;
    }
  }

  if (addBtn) {
    addBtn.onclick = function(){
      var index = document.querySelectorAll('#choiceWrap .choice-row').length;
      var row = document.createElement('div');
      row.className = 'choice-row';
      row.innerHTML = '<input type="radio" name="correct_choice" value="' + index + '">' +
                      '<input type="text" name="choice_text[]" placeholder="Choice text">' +
                      '<button class="btn btn-danger remove-choice" type="button">Remove</button>';
      wrap.appendChild(row);
      bindRemoveButtons();
      refreshRadioValues();
    };
  }

  bindRemoveButtons();
})();