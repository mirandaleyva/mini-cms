<?php
declare(strict_types=1);

final class FileLogger implements LoggerInterface
{
    public function __construct(private string $filePath){}
    
    public function debug(string $message): void{
      $line = date('c') . " DEBUG " . $message . PHP_EOL;
      file_put_contents($this->filePath, $line, FILE_APPEND);
    }
}