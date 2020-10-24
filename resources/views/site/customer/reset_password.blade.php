@component('mail::panel')
Vui lòng nhấp vào nút bên dưới nếu bạn muốn thay đổi mật khẩu của mình
@endcomponent
@component('mail::button', ['url' => $url])
Thay đổi mật khẩu
	@endcomponent
@component('mail::footer')
	Nếu bạn không muốn thay đổi mật khẩu thì không cần phải làm gì
@endcomponent

