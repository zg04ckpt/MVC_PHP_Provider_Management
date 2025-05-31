<?php
enum OrderStatus: string {
    case Wait = 'wait';
    case WaitPay = 'wait_pay';
    case Paid = 'paid';
}
