'use strict';

let toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      const popupEnd = document.querySelector('.shop-page__popup-end');

      buttonOrder.addEventListener('click', (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        inputs.forEach(inp => {

          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

          evt.preventDefault();

          toggleHidden(shopOrder, popupEnd);

          popupEnd.classList.add('fade');
          setTimeout(() => popupEnd.classList.remove('fade'), 1000);

          window.scroll(0, 0);

          const buttonEnd = popupEnd.querySelector('.button');

          buttonEnd.addEventListener('click', () => {


            popupEnd.classList.add('fade-reverse');

            setTimeout(() => {

              popupEnd.classList.remove('fade-reverse');

              toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

            }, 1000);

          });

        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      });
    }
  });
}


const prods = document.querySelectorAll('.product');

prods.forEach((product) => {
  product.addEventListener('click', (e) => {
    let strGET = window.location.search.replace( '?', ''); 
    if (strGET) {
      window.location.replace('/order/?' + strGET + '&productID=' + e.target.id);
    } else {
      window.location.replace('/order/?productID=' + e.target.id);
    }
    
  })
})



$("#productPhoto").change(function(){
	if (window.FormData === undefined) {
		alert('В вашем браузере загрузка файлов не поддерживается');
	} else {
		var formData = new FormData();
		$.each($("#productPhoto")[0].files, function(key, input){
			formData.append('file[]', input);
		});
		$.ajax({
			type: 'POST',
			url: '/products/add/upload_image.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType : 'json',
			success: function(msg){
				msg.forEach(function(row) {
					if (row.error != '') {
						alert(row.error);
					} 
          if (row.error == '') {
						$('.new-item').append(row.data);
					}
				});
				$("#productPhoto").val(''); 
			}
		});
	}
});



const changeStatusAjax = (id, status) => {
  const block = document.querySelector('#change_id_' + id);
  const parent = block.parentNode;
  const statusContainer = parent.querySelector('.order-item__info__status');
  fetch('/orders/changeStatus.php', {
      method: 'POST',
      body: JSON.stringify({id: id, status: status}),
  })
  .then(response => response.json())
  .then((data) => {
    console.log(data);
    if (data) {

      statusContainer.innerText='';
      statusContainer.innerText = data;
      if (data === 'Обработан') {
        statusContainer.classList.remove('red');
        statusContainer.classList.add('green');
      } else {
        statusContainer.classList.remove('green');
        statusContainer.classList.add('red');
      }
      parent.append(child);
        
    }
    if (!data) {
      parent.classList.add('red'); 
      parent.innerText = 'Ошибка!';
    }
  })
}
  

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

pageOrderList.addEventListener('click', evt => {


if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
  var path = evt.path || (evt.composedPath && evt.composedPath());
  Array.from(path).forEach(element => {

    if (element.classList && element.classList.contains('page-order__item')) {

      element.classList.toggle('order-item--active');

    }

  });

  evt.target.classList.toggle('order-item__toggle--active');

}

});
}
const arrows = document.querySelectorAll('.arrow') 
const showList = document.querySelectorAll('.showList') 
arrows.forEach(arrow => 
arrow.addEventListener('click', (e) => {
const toggledList = e.target.parentNode.parentNode.lastChild;
toggledList.classList.toggle('disabled');

})
)


    const changeUserRole = (el_id) => {
      const select = document.querySelector('#change_' + el_id);
      const role = document.getElementById('role_' + el_id);
      select.hidden = false;
      role.hidden = true;
  
  }
  const text = [
   'Admin', 'Operator', 'Buyer'   
  ];
  const change = (el_id) => {
      const select = document.querySelector('#change_' + el_id);
      const val = document.querySelector('#change_' + el_id).value;
      const role = document.getElementById('role_' + el_id);
          
      role.hidden = false;
      select.hidden = true;
      fetch('/admin/accessRights/changeUsersRole.php', {
            method: 'POST',
            body: JSON.stringify({id: el_id, role: val}),
        }).then(response => response.json())
        .then((resp) => {
            if (resp) {
              text.forEach((el, index) => {
                  if ((index+1) == Number(resp)) {
                      role.innerText = el;
                  }
              })
            } else {
              role.classList.add('red');
              role.innerText = 'Error';
            }
        })  
  }