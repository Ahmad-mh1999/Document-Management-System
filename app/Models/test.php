للتعامل مع ملفات Word و PowerPoint و Excel في Laravel، يمكنك استخدام مكتبات مثل PhpOffice’s PhpWord و PhpSpreadsheet. هذه المكتبات توفر واجهات برمجة تطبيقات (APIs) لقراءة وكتابة ملفات Word و PowerPoint و Excel.

أولاً، ستحتاج إلى تثبيت هذه المكتبات عبر Composer:

composer require phpoffice/phpspreadsheet
composer require phpoffice/phpword

بعد ذلك، يمكنك استخدام هذه المكتبات في نموذج Document للتعامل مع الملفات. إليك كيفية القيام بذلك:

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

class Document extends Model
{
    protected $fillable = ['file'];

    public function setFileAttribute($value)
    {
        if ($value) {
            $this->attributes['file'] = time() . '.' . $value->getClientOriginalExtension();

            // يمكنك التعامل مع أنواع الملفات المختلفة هنا
            switch ($value->getClientOriginalExtension()) {
                case 'docx':
                    $phpWord = WordIOFactory::load($value->getRealPath());
                    // الآن يمكنك التعامل مع ملف Word
                    break;
                case 'pptx':
                    $phpPresentation = IOFactory::load($value->getRealPath());
                    // الآن يمكنك التعامل مع ملف PowerPoint
                    break;
                case 'xlsx':
                    $spreadsheet = IOFactory::load($value->getRealPath());
                    // الآن يمكنك التعامل مع ملف Excel
                    break;
            }

            // ثم قم بحفظ الملف في المسار المطلوب
            Storage::disk('local')->put('documents/' . $this->attributes['file'], file_get_contents($value->getRealPath()));
        }
    }
}
// رمز تم إنشاؤه بواسطة الذكاء الاصطناعي. الرجاء المراجعة والاستخدام بعناية. مزيد من المعلومات حول الأسئلة المتداولة.
// في الكود أعلاه، قمنا بإنشاء دالة setFileAttribute في نموذج Document. هذه الدالة ستتم استدعاؤها تلقائيًا عندما نحاول تعيين قيمة للخاصية ‘file’. في هذه الدالة، نقوم بالتحقق من نوع الملف ومن ثم نقوم بالتعامل معه بشكل مختلف بناءً على نوعه.

// أتمنى أن يكون هذا الشرح مفيدًا لك. إذا كنت بحاجة إلى مزيد من المعلومات أو لديك أي أسئلة أخرى، فلا تتردد في طرحها.

// تعرّف على المزيد