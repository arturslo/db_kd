<?php


namespace App\Message;


use Illuminate\Contracts\Support\Arrayable;

class Message implements Arrayable
{
    public ?int $MessageId;
    public string $OrderNo;
    public string $Text;

    /**
     * Message constructor.
     * @param int|null $MessageId
     * @param string $OrderNo
     * @param string $Text
     */
    public function __construct(?int $MessageId = null, string $OrderNo, string $Text)
    {
        $this->MessageId = $MessageId;
        $this->OrderNo = $OrderNo;
        $this->Text = $Text;
    }


    public function toArray()
    {
        return [
            'MessageId' => $this->MessageId,
            'OrderNo' => $this->OrderNo,
            'Text' => $this->Text,
        ];
    }
}
