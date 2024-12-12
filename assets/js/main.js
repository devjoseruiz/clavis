$(document).ready(function() {

  // Toast for notifications
  //toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!');

  // Waitme
  //$('body').waitMe({effect : 'orbit'});
  console.log('////////// Welcome to Bee Framework Version ' + Bee.bee_version + ' //////////');
  console.log('//////////////////// www.joystick.com.mx ////////////////////');
  console.log(Bee);

  /**
   * Test for AJAX requests to backend in version 1.1.3
   */
  function test_ajax() {
    var body = $('body'),
    hook     = 'bee_hook',
    action   = 'post',
    csrf     = Bee.csrf;

    if ($('#test_ajax').length == 0) return;

    $.ajax({
      url: 'ajax/test',
      type: 'post',
      dataType: 'json',
      data : { hook , action , csrf },
      beforeSend: function() {
        body.waitMe();
      }
    }).done(function(res) {
      toastr.success(res.msg);
      console.log(res);
    }).fail(function(err) {
      toastr.error('AJAX test failed.', 'Oops!');
    }).always(function() {
      body.waitMe('hide');
    })
  }
  
  /**
   * Alert to confirm an action set in a specific link or route
   */
  $('body').on('click', '.confirmar', function(e) {
    e.preventDefault();

    let url = $(this).attr('href'),
    ok      = confirm('Are you sure?');

    // Redirect to the link URL
    if (ok) {
      window.location = url;
      return true;
    }
    
    console.log('Action cancelled.');
    return true;
  });

  /**
   * Initialize summernote advanced text editor for textareas
   */
  function init_summernote() {
    if ($('.summernote').length == 0) return;

    $('.summernote').summernote({
      placeholder: 'Write in this field...',
      tabsize: 2,
      height: 300
    });
  }

  /**
   * Initialize tooltips across the site
   */
  function init_tooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  }
  
  // Initialize elements
  init_summernote();
  init_tooltips();
  test_ajax();

  ////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////
  ///////// NOT REQUIRED, ONLY FOR THE DEMO PROJECT OF EXPENSES AND INCOME
  ////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////
  
  // Add a movement
  $('.bee_add_movement').on('submit', bee_add_movement);
  function bee_add_movement(event) {
    event.preventDefault();

    var form    = $('.bee_add_movement'),
    hook        = 'bee_hook',
    action      = 'add',
    data        = new FormData(form.get(0)),
    type        = $('#type').val(),
    description = $('#description').val(),
    amount      = $('#amount').val();
    data.append('hook', hook);
    data.append('action', action);

    // Validate that a type option is selected
    if(type === 'none') {
      toastr.error('Select a valid movement type', 'Oops!');
      return;
    }

    // Validate description
    if(description === '' || description.length < 5) {
      toastr.error('Enter a valid description', 'Oops!');
      return;
    }

    // Validate amount
    if(amount === '' || amount <= 0) {
      toastr.error('Enter a valid amount', 'Oops!');
      return;
    }

    // AJAX
    $.ajax({
      url: 'ajax/bee_add_movement',
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      cache: false,
      data : data,
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 201) {
        toastr.success(res.msg, 'Great!');
        form.trigger('reset');
        bee_get_movements();
      } else {
        toastr.error(res.msg, 'Oops!');
      }
    }).fail(function(err) {
      toastr.error('There was an error in the request', 'Oops!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  // Load movements
  bee_get_movements();
  function bee_get_movements() {
    var wrapper = $('.bee_wrapper_movements'),
    hook        = 'bee_hook',
    action      = 'load';

    if (wrapper.length === 0) {
      return;
    }

    $.ajax({
      url: 'ajax/bee_get_movements',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper.html(res.data);
      } else {
        toastr.error(res.msg, 'Oops!');
        wrapper.html('');
      }
    }).fail(function(err) {
      toastr.error('There was an error in the request', 'Oops!');
      wrapper.html('');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }

  // Update a movement
  $('body').on('dblclick', '.bee_movement', bee_update_movement);
  function bee_update_movement(event) {
    var li              = $(this),
    id                  = li.data('id'),
    hook                = 'bee_hook',
    action              = 'get',
    add_form            = $('.bee_add_movement'),
    wrapper_update_form = $('.bee_wrapper_update_form');

    // AJAX
    $.ajax({
      url: 'ajax/bee_update_movement',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action, id
      },
      beforeSend: function() {
        wrapper_update_form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper_update_form.html(res.data);
        add_form.hide();
      } else {
        toastr.error(res.msg, 'Oops!');
      }
    }).fail(function(err) {
      toastr.error('There was an error in the request', 'Oops!');
    }).always(function() {
      wrapper_update_form.waitMe('hide');
    })
  }

  $('body').on('submit', '.bee_save_movement', bee_save_movement);
  function bee_save_movement(event) {
    event.preventDefault();

    var form    = $('.bee_save_movement'),
    hook        = 'bee_hook',
    action      = 'update',
    data        = new FormData(form.get(0)),
    type        = $('select[name="type"]', form).val(),
    description = $('input[name="description"]', form).val(),
    amount      = $('input[name="amount"]', form).val(),
    add_form            = $('.bee_add_movement');
    data.append('hook', hook);
    data.append('action', action);

    // Validate that a type option is selected
    if(type === 'none') {
      toastr.error('Select a valid movement type', 'Oops!');
      return;
    }

    // Validate description
    if(description === '' || description.length < 5) {
      toastr.error('Enter a valid description', 'Oops!');
      return;
    }

    // Validate amount
    if(amount === '' || amount <= 0) {
      toastr.error('Enter a valid amount', 'Oops!');
      return;
    }

    // AJAX
    $.ajax({
      url: 'ajax/bee_save_movement',
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      cache: false,
      data : data,
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Great!');
        form.trigger('reset');
        form.remove();
        add_form.show();
        bee_get_movements();
      } else {
        toastr.error(res.msg, 'Oops!');
      }
    }).fail(function(err) {
      toastr.error('There was an error in the request', 'Oops!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  // Delete a movement
  $('body').on('click', '.bee_delete_movement', bee_delete_movement);
  function bee_delete_movement(event) {
    var li    = $(this).closest('li'),
    id        = li.data('id'),
    hook      = 'bee_hook',
    action    = 'delete',
    confirmed = confirm('Are you sure you want to delete this movement?');

    if (!confirmed) return;

    // AJAX
    $.ajax({
      url: 'ajax/bee_delete_movement',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action, id
      },
      beforeSend: function() {
        li.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        li.fadeOut(function() {
          li.remove();
        });
        toastr.success(res.msg, 'Great!');
      } else {
        toastr.error(res.msg, 'Oops!');
      }
    }).fail(function(err) {
      toastr.error('There was an error in the request', 'Oops!');
    }).always(function() {
      li.waitMe('hide');
    })
  }

  // Save or update options
  $('.bee_save_options').on('submit', bee_save_options);
  function bee_save_options(event) {
    event.preventDefault();

    var form = $('.bee_save_options'),
    data     = new FormData(form.get(0)),
    hook     = 'bee_hook',
    action   = 'add';
    data.append('hook', hook);
    data.append('action', action);

    // AJAX
    $.ajax({
      url: 'ajax/bee_save_options',
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      cache: false,
      data : data,
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Great!');
      } else {
        toastr.error(res.msg, 'Oops!');
      }
    }).fail(function(err) {
      toastr.error('There was an error in the request', 'Oops!');
    }).always(function() {
      form.waitMe('hide');
    })
  }
});