### API для платежной системы
Шифрование карточных данных, получение криптограммы.
POST /api/token

Пример входных данных: JSON, данные карты
```
{
	"pan":"1234123412341234",
	"cvc":"123",
	"cardholder":"Card Holder",
	"expire":"10/22"
}
```
Предусмотрена валидация входных данных:
```
pan - 16 цифр, проверяет по алгоритму Луна (https://en.wikipedia.org/wiki/Luhn_algorithm)
cvc - строго 3 цифры
cardholder - строка
expire - дата действия карты в формате месяц (две цифры) / год (последние 2 цифры) не должны быть меньше текущей даты
```
В случае ошибки - запись в лог, ответ в JSON какая ошибка, соответствующий по смыслу http код.

После валидации входных данных,  к ним добавляется поле tokenExpire в котором в формате timestamp установлена дата, когда токен считаем невалидным.
Вычисляется как now() + tokenTTL, где tokenTTL читается из конфига сервиса.

Затем данные (пересобранная JSON строка с датой до которой токен валиден) — шифруются с помощью RSA (ключ читается из файловой системы. Сгенерировать пару приватный+публичный ключи)

Результат кодируется в base64 и логируется (только результат, исходный запрос с данными карты не сохраняется)

Сервис отдает ответ в формате JSON:
```
{
	"pan":"1234**1234", // маскированный номер карты: первые 4 и последние 4 цифры
	"token":"eyJhYWEiOiJiYnN…….mZsa2RmanZiIn0="
}
```

### Используемые ресурсы: 
```
php 8.1
laravel 9
gotzmann/comet
monolog/monolog
ext-ctype
ext-openssl
```
### Инсталяция
1) Установить php 8.1
2) Скопировать папку "apitest" на сервер Linux
3) Запустить командой
   ```php app.php start```