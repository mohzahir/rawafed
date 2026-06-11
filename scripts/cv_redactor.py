import sys
import fitz  # مكتبة PyMuPDF
import re    # مكتبة التعابير النمطية (Regex)
import json
import base64

def generate_arabic_variations(word):
    """دالة ذكية لتوليد احتمالات الأخطاء الإملائية الشائعة في الأسماء العربية"""
    variations = {word}
    
    # معالجة التاء المربوطة والهاء
    if word.endswith('ة'): variations.add(word[:-1] + 'ه')
    if word.endswith('ه'): variations.add(word[:-1] + 'ة')
    
    # معالجة الهمزات والألف
    if word.startswith('أ') or word.startswith('إ') or word.startswith('آ'):
        variations.add('ا' + word[1:])
    if word.startswith('ا'):
        variations.add('أ' + word[1:])
        variations.add('إ' + word[1:])
        
    # معالجة الياء والألف المقصورة
    if word.endswith('ي'): variations.add(word[:-1] + 'ى')
    if word.endswith('ى'): variations.add(word[:-1] + 'ي')
    
    return list(variations)

def redact_smart_pdf(input_path, output_path, name, email, phone, ai_targets_b64):
    try:
        doc = fitz.open(input_path)

        # --- 1. الفحص الذكي: هل هذا الملف عبارة عن صورة (سكانر)؟ ---
        total_text = ""
        for page in doc:
            total_text += page.get_text("text")
            
        if len(total_text.strip()) < 50:
            print("SCANNED_IMAGE")
            return 
        # --------------------------------------------------------
        
        items_to_redact = set()

        # --- 2. إضافة البيانات القادمة من الذكاء الاصطناعي (الأسماء الحرفية في الـ CV) ---
        if ai_targets_b64 and ai_targets_b64 != "NONE":
            try:
                # فك التشفير عن المصفوفة القادمة من PHP
                ai_targets_json = base64.b64decode(ai_targets_b64).decode('utf-8')
                ai_targets_list = json.loads(ai_targets_json)
                
                for item in ai_targets_list:
                    if isinstance(item, str) and len(item.strip()) > 2:
                        items_to_redact.add(item.strip())
                        # توليد احتمالات الأسماء التي أخرجها الذكاء الاصطناعي أيضاً
                        items_to_redact.update(generate_arabic_variations(item.strip()))
            except Exception as e:
                pass # في حال فشل فك التشفير، نتجاهلها ونعتمد على الباقي

        # --- 3. التعابير النمطية (Regex) كطبقة حماية احتياطية ---
        email_pattern = r'[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}'
        phone_pattern = r'(\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9})'
        link_pattern = r'(https?://[^\s]+|www\.[^\s]+|linkedin\.com[^\s]+)'

        for page in doc:
            text = page.get_text("text")
            
            items_to_redact.update(re.findall(email_pattern, text))
            
            phones = re.findall(phone_pattern, text)
            for p in phones:
                digits_only = re.sub(r'\D', '', p)
                if 8 <= len(digits_only) <= 16:
                    items_to_redact.add(p.strip())
            
            items_to_redact.update(re.findall(link_pattern, text))

        # --- 4. إضافة البيانات من الفورم ---
        if email: items_to_redact.add(email)
        if phone: items_to_redact.add(phone)

        if name:
            name_parts = name.split()
            for part in name_parts:
                if len(part) > 2:
                    variations = generate_arabic_variations(part)
                    items_to_redact.update(variations)
            if len(name_parts) >= 2:
                items_to_redact.add(f"{name_parts[0]} {name_parts[-1]}")

        # --- 5. تنفيذ الطمس النهائي والمشدد ---
        for page in doc:
            for item in items_to_redact:
                if not item or len(item) < 3: continue
                
                # إعدادات البحث لتكون دقيقة ولا تعتمد على حالة الأحرف
                areas = page.search_for(item)
                for area in areas:
                    page.add_redact_annot(area, fill=(0, 0, 0))
            
            page.apply_redactions()

        # ==============================================================================
        # --- 6. إضافة العلامة المائية تحت النص ---
        # ==============================================================================
        watermark_text = "RAWAFED MEDICAL TALENT - CONFIDENTIAL"
        font_name = "helv" 
        font_size = 32 
        text_color = (0.85, 0.85, 0.85) 
        rotation_angle = -35 
        m_rotation = fitz.Matrix(rotation_angle)
        
        for page in doc:
            page_rect = page.rect
            width = page_rect.width
            height = page_rect.height
            
            x_step = 550 
            y_step = 300 
            curr_y = -height 
            
            while curr_y < height * 2:
                curr_x = -width + ( (curr_y / y_step) % 2 * 200 ) 
                while curr_x < width * 2:
                    point = fitz.Point(curr_x, curr_y)
                    page.insert_text(
                        point,
                        watermark_text,
                        fontsize=font_size,
                        fontname=font_name,
                        color=text_color,
                        morph=(point, m_rotation), 
                        overlay=False 
                    )
                    curr_x += x_step
                curr_y += y_step
        # ==============================================================================
        
        doc.save(output_path)
        print("SUCCESS")

    except Exception as e:
        print(f"ERROR: {str(e)}")

if __name__ == "__main__":
    # تم زيادة عدد المعطيات المطلوبة إلى 6 لاحتواء بيانات الذكاء الاصطناعي
    if len(sys.argv) > 6:
        redact_smart_pdf(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4], sys.argv[5], sys.argv[6])
    else:
        print("ERROR: Missing arguments")