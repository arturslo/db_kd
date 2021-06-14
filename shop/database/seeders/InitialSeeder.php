<?php

namespace Database\Seeders;

use App\BankPayment\BankPayment;
use App\BankPayment\BankPaymentRepository;
use App\Basket\Basket;
use App\Basket\BasketRepository;
use App\BasketProduct\BasketProduct;
use App\BasketProduct\BasketProductRepository;
use App\Client\Client;
use App\Client\ClientRepository;
use App\Message\Message;
use App\Message\MessageRepository;
use App\Order\Order;
use App\Order\OrderRepository;
use App\Product\Product;
use App\Product\ProductRepository;
use App\ProductType\ProductType;
use App\ProductType\ProductTypeRepository;
use App\User\User;
use App\User\UserRepository;
use App\WarehouseRecord\WarehouseRecord;
use App\WarehouseRecord\WarehouseRecordRepository;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run(
        ClientRepository $clientRepository,
        ProductTypeRepository $productTypeRepository,
        ProductRepository $productRepository,
        WarehouseRecordRepository $warehouseRecordRepository,
        BasketRepository $basketRepository,
        BasketProductRepository $basketProductRepository,
        OrderRepository $orderRepository,
        BankPaymentRepository $bankPaymentRepository,
        MessageRepository $messageRepository,
        UserRepository $userRepository,
    ): void {
        $clientValues = [
            ['Firstname' => 'Janis', 'Lastname' => 'Ozols', 'Email' => 'janisozols@gmail.com', 'Password' => 'qwerty'],
            ['Firstname' => 'Juris', 'Lastname' => 'Spuris', 'Email' => 'jurisspuris@gmail.com', 'Password' => 'qwerty'],
            ['Firstname' => 'Anna', 'Lastname' => 'Kadike', 'Email' => 'annak@gmail.com', 'Password' => 'qwerty'],
            ['Firstname' => 'Zanne', 'Lastname' => 'Berzs', 'Email' => 'zanneb@gmail.com', 'Password' => 'qwerty'],
            ['Firstname' => 'Karlis', 'Lastname' => 'Priede', 'Email' => 'karlisp@gmail.com', 'Password' => 'qwerty'],
        ];

        $clients = [];
        foreach ($clientValues as $data) {
            $client = new Client(...$data);
            $client->ClientId = $clientRepository->create($client);
            $clients[$client->ClientId] = $client;
        }

        $productTypeValues = [
            ['Name' => 'beer'],
            ['Name' => 'wine'],
            ['Name' => 'white wine'],
            ['Name' => 'red wine'],
            ['Name' => 'cider'],
            ['Name' => 'rakia'],
            ['Name' => 'whiskey'],
            ['Name' => 'sake'],
            ['Name' => 'brandy'],
            ['Name' => 'vodka'],
            ['Name' => 'tequila'],
        ];

        $productTypes = [];
        foreach ($productTypeValues as $data) {
            $productType = new ProductType(...$data);
            $productType->ProductTypeId = $productTypeRepository->create($productType);
            $productTypes[$productType->ProductTypeId] = $productType;
        }

        $productValues = [
            ['ProductNo' => 'N3123', 'ProductTypeId' => 1, 'ProductName' => 'Corona Extra Mexican Lager Beer', 'ABV' => '4.6', 'Price' => '1.30'],
            ['ProductNo' => 'N3432', 'ProductTypeId' => 2, 'ProductName' => 'Llopart Reserva Brut Rose Corpinnat Penedes Magnum Organic', 'ABV' => '12', 'Price' => '39.00'],
            ['ProductNo' => 'N3462', 'ProductTypeId' => 3, 'ProductName' => 'De Loach Heritage Reserve Chardonnay California', 'ABV' => '13.5', 'Price' => '17.50'],
            ['ProductNo' => 'N3113', 'ProductTypeId' => 4, 'ProductName' => 'Raymond Vineyards Reserve Selection Cabernet Sauvignon Napa Valley', 'ABV' => '14.5', 'Price' => '65.00'],
            ['ProductNo' => 'N3133', 'ProductTypeId' => 5, 'ProductName' => 'Bilpin Non Alcoholic Cider', 'ABV' => '0', 'Price' => '2.67'],
            ['ProductNo' => 'N3127', 'ProductTypeId' => 6, 'ProductName' => 'Black Sea Gold Pomorie Alambic Rakia', 'ABV' => '40', 'Price' => '39.90'],
            ['ProductNo' => 'N2113', 'ProductTypeId' => 7, 'ProductName' => 'Whiskey Macallan 12YO', 'ABV' => '40', 'Price' => '65.00'],
            ['ProductNo' => 'N3163', 'ProductTypeId' => 8, 'ProductName' => 'Asashi Shuzo Dassai 45 Junmai Daiginjo Sake', 'ABV' => '16', 'Price' => '32.00'],
            ['ProductNo' => 'N3173', 'ProductTypeId' => 9, 'ProductName' => 'Rémy Martin 1738® Accord Royal', 'ABV' => '40', 'Price' => '79.99'],
            ['ProductNo' => 'N3183', 'ProductTypeId' => 10, 'ProductName' => 'Vodka Beluga', 'ABV' => '40', 'Price' => '39.00'],
            ['ProductNo' => 'N3193', 'ProductTypeId' => 11, 'ProductName' => 'Padre Azul Reposado Super Premium', 'ABV' => '38', 'Price' => '85.00'],
        ];

        $products = [];
        foreach ($productValues as $data) {
            $product = new Product(...$data);
            $product->ProductNo = $productRepository->create($product);
            $products[$product->ProductNo] = $product;
        }

        $warehouseRecords = [];
        $warehouseRecordValues = [
            ['ProductNo' => 'N3123', 'AmountChange' => 2, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3123', 'AmountChange' => 22, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3432', 'AmountChange' => 33, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3432', 'AmountChange' => 2, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3462', 'AmountChange' => 13, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3462', 'AmountChange' => 2, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3113', 'AmountChange' => 2, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3113', 'AmountChange' => 1, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3133', 'AmountChange' => 12, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3133', 'AmountChange' => 1, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3127', 'AmountChange' => 15, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3127', 'AmountChange' => 1, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N2113', 'AmountChange' => 14, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N2113', 'AmountChange' => 1, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N2113', 'AmountChange' => 1, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3163', 'AmountChange' => 31, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3173', 'AmountChange' => 12, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3173', 'AmountChange' => 4, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3183', 'AmountChange' => 13, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3183', 'AmountChange' => 13, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3193', 'AmountChange' => 4, 'Comment' => 'Added stock'],
            ['ProductNo' => 'N3193', 'AmountChange' => 72, 'Comment' => 'Added stock'],
        ];

        foreach ($warehouseRecordValues as $data) {
            $warehouseRecord = new WarehouseRecord(...$data);
            $warehouseRecord->WarehouseRecordId = $warehouseRecordRepository->create($warehouseRecord);
            $warehouseRecords[$warehouseRecord->WarehouseRecordId] = $warehouseRecord;
        }

        $basketValues = [
            ['ClientId' => 1],
            ['ClientId' => 2],
            ['ClientId' => 3],
            ['ClientId' => 4],
            ['ClientId' => 5],
            ['ClientId' => 1],
            ['ClientId' => 2],
            ['ClientId' => 3],
            ['ClientId' => 4],
            ['ClientId' => 5],
            ['ClientId' => 1],
            ['ClientId' => 2],
        ];

        $baskets = [];
        foreach ($basketValues as $data) {
            $basket = new Basket(...$data);
            $basket->BasketId = $basketRepository->create($basket);
            $baskets[$basket->BasketId] = $basket;
        }

        $basketProductValues = [
            ['BasketId' => 1, 'ProductNo' => 'N2113', 'Quantity' => 1],
            ['BasketId' => 1, 'ProductNo' => 'N3113', 'Quantity' => 2],
            ['BasketId' => 2, 'ProductNo' => 'N3123', 'Quantity' => 3],
            ['BasketId' => 2, 'ProductNo' => 'N3127', 'Quantity' => 4],
            ['BasketId' => 3, 'ProductNo' => 'N3133', 'Quantity' => 3],
            ['BasketId' => 3, 'ProductNo' => 'N3163', 'Quantity' => 2],
            ['BasketId' => 4, 'ProductNo' => 'N3173', 'Quantity' => 1],
            ['BasketId' => 5, 'ProductNo' => 'N3183', 'Quantity' => 2],
            ['BasketId' => 6, 'ProductNo' => 'N3193', 'Quantity' => 3],
            ['BasketId' => 7, 'ProductNo' => 'N3193', 'Quantity' => 4],
            ['BasketId' => 8, 'ProductNo' => 'N3432', 'Quantity' => 3],
            ['BasketId' => 8, 'ProductNo' => 'N3462', 'Quantity' => 2],
            ['BasketId' => 9, 'ProductNo' => 'N3193', 'Quantity' => 1],
            ['BasketId' => 10, 'ProductNo' => 'N3183', 'Quantity' => 2],
            ['BasketId' => 11, 'ProductNo' => 'N3193', 'Quantity' => 3],
            ['BasketId' => 12, 'ProductNo' => 'N3133', 'Quantity' => 2],
            ['BasketId' => 12, 'ProductNo' => 'N3123', 'Quantity' => 1],
            ['BasketId' => 12, 'ProductNo' => 'N3462', 'Quantity' => 2],
        ];

        $basketProducts = [];
        foreach ($basketProductValues as $data) {
            $basketProduct = new BasketProduct(...$data);
            $basketProductRepository->create($basketProduct);
            $basketProducts[] = $basketProduct;
        }

        $orderValues = [
            ['OrderNo' => 'ORD123', 'BasketId' => 1, 'CreatedAt' => '2021-05-22 08:10:44', 'Status' => Order::STATUS_PENDING],
            ['OrderNo' => 'ORD124', 'BasketId' => 2, 'CreatedAt' => '2021-05-23 08:10:44', 'Status' => Order::STATUS_PENDING],
            ['OrderNo' => 'ORD125', 'BasketId' => 3, 'CreatedAt' => '2021-05-24 08:10:44', 'Status' => Order::STATUS_PENDING],
            ['OrderNo' => 'ORD126', 'BasketId' => 4, 'CreatedAt' => '2021-05-24 08:10:44', 'Status' => Order::STATUS_PENDING],
            ['OrderNo' => 'ORD127', 'BasketId' => 5, 'CreatedAt' => '2021-05-25 08:10:44', 'Status' => Order::STATUS_CANCELED],
            ['OrderNo' => 'ORD128', 'BasketId' => 6, 'CreatedAt' => '2021-05-26 08:10:44', 'Status' => Order::STATUS_CANCELED],
            ['OrderNo' => 'ORD129', 'BasketId' => 7, 'CreatedAt' => '2021-05-26 08:10:44', 'Status' => Order::STATUS_PENDING],
            ['OrderNo' => 'ORD130', 'BasketId' => 8, 'CreatedAt' => '2021-05-27 08:10:44', 'Status' => Order::STATUS_PENDING],
            ['OrderNo' => 'ORD131', 'BasketId' => 9, 'CreatedAt' => '2021-05-28 08:10:44', 'Status' => Order::STATUS_PAID],
            ['OrderNo' => 'ORD132', 'BasketId' => 10, 'CreatedAt' => '2021-05-29 08:10:44', 'Status' => Order::STATUS_PAID],
            ['OrderNo' => 'ORD133', 'BasketId' => 11, 'CreatedAt' => '2021-05-29 08:10:44', 'Status' => Order::STATUS_PAID],
            ['OrderNo' => 'ORD134', 'BasketId' => 12, 'CreatedAt' => '2021-05-29 08:10:44', 'Status' => Order::STATUS_PAID],
        ];

        $orders = [];
        foreach ($orderValues as $data) {
            $order = new Order(...$data);
            $orderRepository->create($order);
            $orders[$order->OrderNo] = $order;
        }

        $bankPaymentValues = [
            ['BankPaymentId' => '1231-1232-3201', 'OrderNo' => 'ORD123', 'Amount' => '32.09', 'Status' => 'PENDING'],
            ['BankPaymentId' => '1231-1232-3202', 'OrderNo' => 'ORD124', 'Amount' => '22.11', 'Status' => 'PENDING'],
            ['BankPaymentId' => '1231-1232-3203', 'OrderNo' => 'ORD125', 'Amount' => '12.21', 'Status' => 'PENDING'],
            ['BankPaymentId' => '1231-1232-3204', 'OrderNo' => 'ORD126', 'Amount' => '42.43', 'Status' => 'PENDING'],
            ['BankPaymentId' => '1231-1232-3205', 'OrderNo' => 'ORD127', 'Amount' => '52.44', 'Status' => 'CANCELED'],
            ['BankPaymentId' => '1231-1232-3206', 'OrderNo' => 'ORD128', 'Amount' => '10.03', 'Status' => 'CANCELED'],
            ['BankPaymentId' => '1231-1232-3207', 'OrderNo' => 'ORD129', 'Amount' => '07.32', 'Status' => 'PENDING'],
            ['BankPaymentId' => '1231-1232-3208', 'OrderNo' => 'ORD130', 'Amount' => '32.22', 'Status' => 'PENDING'],
            ['BankPaymentId' => '1231-1232-3209', 'OrderNo' => 'ORD131', 'Amount' => '54.43', 'Status' => 'PAID'],
            ['BankPaymentId' => '1231-1232-3210', 'OrderNo' => 'ORD132', 'Amount' => '43.43', 'Status' => 'PAID'],
            ['BankPaymentId' => '1231-1232-3211', 'OrderNo' => 'ORD133', 'Amount' => '32.55', 'Status' => 'PAID'],
            ['BankPaymentId' => '1231-1232-3212', 'OrderNo' => 'ORD134', 'Amount' => '05.32', 'Status' => 'PAID'],
        ];

        $bankPayments = [];
        foreach ($bankPaymentValues as $data) {
            $bankPayment = new BankPayment(...$data);
            $bankPaymentRepository->create($bankPayment);
            $bankPayments[$bankPayment->BankPaymentId] = $bankPayment;
        }

        $messageValues = [
            ['OrderNo' => 'ORD123', 'Text' => 'Order: ORD123 PENDING'],
            ['OrderNo' => 'ORD124', 'Text' => 'Order: ORD124 PENDING'],
            ['OrderNo' => 'ORD125', 'Text' => 'Order: ORD125 PENDING'],
            ['OrderNo' => 'ORD126', 'Text' => 'Order: ORD126 PENDING'],
            ['OrderNo' => 'ORD127', 'Text' => 'Order: ORD127 PENDING'],
            ['OrderNo' => 'ORD127', 'Text' => 'Order: ORD127 CANCELLED'],
            ['OrderNo' => 'ORD128', 'Text' => 'Order: ORD128 PENDING'],
            ['OrderNo' => 'ORD128', 'Text' => 'Order: ORD128 CANCELLED'],
            ['OrderNo' => 'ORD129', 'Text' => 'Order: ORD129 PENDING'],
            ['OrderNo' => 'ORD130', 'Text' => 'Order: ORD130 PENDING'],
            ['OrderNo' => 'ORD131', 'Text' => 'Order: ORD131 PENDING'],
            ['OrderNo' => 'ORD131', 'Text' => 'Order: ORD131 PAID'],
            ['OrderNo' => 'ORD132', 'Text' => 'Order: ORD132 PENDING'],
            ['OrderNo' => 'ORD132', 'Text' => 'Order: ORD132 PAID'],
            ['OrderNo' => 'ORD133', 'Text' => 'Order: ORD133 PENDING'],
            ['OrderNo' => 'ORD133', 'Text' => 'Order: ORD133 PAID'],
            ['OrderNo' => 'ORD134', 'Text' => 'Order: ORD134 PENDING'],
            ['OrderNo' => 'ORD134', 'Text' => 'Order: ORD134 PAID'],
        ];

        $messages = [];
        foreach ($messageValues as $data) {
            $message = new Message(...$data);
            $message->MessageId = $messageRepository->create($message);
            $messages[$message->MessageId] = $message;
        }

        $userValues = [
            ['Firstname' => 'Boris', 'Lastname' => 'Zakis', 'Email' => 'borzak@gmail.com', 'Password' => 'qwerty'],
            ['Firstname' => 'Elina', 'Lastname' => 'Zvaigzne', 'Email' => 'elzva@gmail.com', 'Password' => 'qwerty'],
        ];

        $users = [];
        foreach ($userValues as $data) {
            $user = new User(...$data);
            $user->UserId = $userRepository->create($user);
            $users[$user->UserId] = $user;
        }
    }
}
