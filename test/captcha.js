//после загрузки веб-страницы
jQuery(function () {

  // при отправке формы messageForm на сервер (id="messageForm")
  jQuery('#messageForm').submit(function (event) {
    // отменим стандартное действие браузера
    event.preventDefault();
    // заведём переменную, которая будет говорить о том валидная форма или нет
    var formValid = true;

    // перебирём все элементы управления формы (input и textarea)
    jQuery('#messageForm input,#messageForm textarea').each(function () {

      //найти предков, имеющих класс .form-group (для установления success/error)
      var formGroup = jQuery(this).parents('.form-group');
      //найти glyphicon (иконка успеха или ошибки)
      var glyphicon = formGroup.find('.form-control-feedback');
      //валидация данных с помощью HTML5 функции checkValidity
      if (this.checkValidity()) {
        //добавить к formGroup класс .has-success и удалить .has-error
        formGroup.addClass('has-success').removeClass('has-error');
        //добавить к glyphicon класс .glyphicon-ok и удалить .glyphicon-remove
        glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove');
      } else {
        //добавить к formGroup класс .has-error и удалить .has-success
        formGroup.addClass('has-error').removeClass('has-success');
        //добавить к glyphicon класс glyphicon-remove и удалить glyphicon-ok
        glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
        //если элемент не прошёл проверку, то отметить форму как не валидную
        formValid = false;
      }
    });

    //проверяем элемент, содержащий код капчи
    //1. Получаем капчу
    var captcha = grecaptcha.getResponse();
    //2. Если длина кода капчи, которой ввёл пользователь не равно 6,
    //   то сразу отмечаем капчу как невалидную (без отправки на сервер)
    if (!captcha.length) {
      // Выводим сообщение об ошибке
      jQuery('#recaptchaError').text('* Вы не прошли проверку "Я не робот"');
    } else {
      // получаем элемент, содержащий капчу
      jQuery('#recaptchaError').text('');
    }

    // если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
    if ((formValid) && (captcha.length)) {

      // получаем имя, которое ввёл пользователь
      var name = jQuery("#name").val();
      // получаем email, который ввёл пользователь
      var email = jQuery("#email").val();
      // получаем сообщение, которое ввёл пользователь
      var message = jQuery("#message").val();
      // получаем телефон, который ввёл пользователь
      var phone = jQuery("#phone").val();
      // получаем адрес сайта, который ввёл пользователь
      var siteurl = jQuery("#siteurl").val();

      // объект, посредством которого будем кодировать форму перед отправкой её на сервер
      var formData = new FormData();
      // добавить в formData значение 'name'=значение_поля_name
      formData.append('name', name);
      // добавить в formData значение 'email'=значение_поля_email
      formData.append('email', email);
      // добавить в formData значение 'message'=значение_поля_message
      formData.append('message', message);
      // добавить в formData значение 'phone'=значение_поля_phone
      formData.append('phone', phone);
      // добавить в formData значение 'siteurl'=значение_поля_siteurl
      formData.append('siteurl', siteurl);
      // добавить в formData значение 'g-recaptcha-response'=значение_recaptcha
      formData.append('g-recaptcha-response', captcha);

      // технология AJAX
      jQuery.ajax({
        //метод передачи запроса - POST
        type: "POST",
        //URL-адрес запроса
        url: "process.php",
        //передаваемые данные - formData
        data: formData,
        // не устанавливать тип контента, т.к. используется FormData
        contentType: false,
        // не обрабатывать данные formData
        processData: false,
        // отключить кэширование результатов в браузере
        cache: false,
        //при успешном выполнении запроса
        success: function (data) {
          // разбираем строку JSON, полученную от сервера
          var jQuerydata =  JSON.parse(data);
          // устанавливаем элементу, содержащему текст ошибки, пустую строку
          jQuery('#error').text('');

          // если сервер вернул ответ success, то значит двнные отправлены
          if (jQuerydata.result == "success") {
            // скрываем форму обратной связи
            jQuery('#messageForm').hide();
            // удаляем у элемента, имеющего id=msgSubmit, класс hidden
            jQuery('#msgSubmit').removeClass('hidden');
          } else {
            // Если сервер вернул ответ error, то делаем следующее...
            jQuery('#error').text('Произошла ошибка при отправке формы на сервер.');
            // Сбрасываем виджет reCaptcha
            grecaptcha.reset();
            // Если существует свойство msg у объекта jQuerydata, то...
            if (jQuerydata.msg) {
              // вывести её в элемент у которого id=recaptchaError
              jQuery('#msg').text(jQuerydata.msg);
            }
          }
        },
        error: function (request) {
          jQuery('#error').text('Произошла ошибка ' + request.responseText + ' при отправке данных.');
        }
      });
    }
  });
});
