# Bss Commerce
## _Hyva Theme Compatible Base Module_

## Những điểm override/thêm mới trong module base này

- Template của block `header.customer` được override sang `Bss_HyvaCompatBase::header/customer-menu.phtml`
- Template của block `product_list_item` được override sang `Bss_HyvaCompatBase::product/list/item.phtml`
- Thêm `responseSerialize` cho fetch API.
- Thêm plugin `component.js` cho AlpineJS.

## Chi Tiết

1. ### Template của block `header.customer` được override
    * Mục đích là để tách nhỏ các link của customer thành từng block, khi implement thì chỉ cần reference vào block `customer.logged-menu` hoặc `customer.not-login-menu` rồi định nghĩa 1 link mới
    * Lý do bởi vì hiện tại Hyva đang viết tất cả các link vào trong cùng 1 block và cùng 1 template.
    * Base class của link là `Bss\HyvaCompatBase\Block\Customer\Menu\CustomerMenuLink` cùng với template là `Bss_HyvaCompatBase::header/customer-menu/link-default.phtml`
    * Chi tiết hơn thì Dev có thể check thêm.
2. ### Thêm plugin `component.js` cho AlpineJS.
    * Mục đích của cái này đó chính là để giao tiếp giữa các component của alpineJS.
    * Hiện tại khi mình tạo 1 block mới, khai báo **x-data** cho block đó thì lại không thể sử dụng được data của **parent** hoặc là của 1 **x-data** khác nằm ngoài phạm vi.
    * **Ví dụ**:
      Tại **cart page**, Hyva có định nghĩa 1 cái là `initCart`, mình tạo block bên trong nó, định nghĩa x-data của mình, nhưng mình muốn sử dụng data của `initCart` (**parrent**) hoặc chỉnh sửa data của `initCart` thì không được (Hoặc có thể do mình kiến thức không đủ nên chưa biết cách thức sử dụng). Nên tìm kiếm trên google thì bắt được cái plugin này dành cho AlpineJS để có thể lấy, sửa được data của các **x-data** khác.

    * ***Note***:
      > Plugin đã được mình sửa 1 chỗ phần tìm kiếm theo tên của component để có thể sử dụng được cho các trường hợp component không được định nghĩa id mà chỉ có functionName.
      `document.querySelector('[x-data="'+a+'()"], [x-data][x-id="'+a+'"]`, trong đó phần được thêm là `'[x-data="'+a+'()"], `.

    * **Cách sử dụng**
      Tại layout cần sử dụng, khai báo handle đã được định nghĩa trong module base. Ví dụ
        ```
        // checkout_cart_index.xml
        <page ..... >
            <update handle="alpinejs_plugins_component"/>
        </page>
        ```
      Tiếp Theo tại phần html có thể sử dụng như dạng
        ```HTML
        <form 
            name="a_form"
            id="submit_form" x-on:submit.prevent="handleSubmitForm($component('componentName'))">
        <!-- Other code -->
        </form>
        ```
      hoặc trong phần JS
        ```JS
        // Other code
        this?.$parent?.cartData &&
        this.$parent.cartData.custom_data = customData;
      
        this?.$component(componentName) &&
        this.$component(componentName).componentTrigger();
        // Other code
        ```
      `componentName` có thể là tên function js mà **component** cần giao tiếp khai báo trogn **x-data** hoặc là id của thẻ chứa x-data (ở trên là `submit_form`), hoặc là giá trị `x-id`
3. ### Thêm thư viện Splide Js
   * Thư viện được sử dụng để làm slide
   * Không ảnh hưởng tới LCP và CLS
