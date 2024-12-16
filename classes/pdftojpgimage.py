import fitz  # PyMuPDF लाइब्रेरी
import os
import json

# PDF का पथ और आउटपुट फोल्डर सेट करें
input_pdf = "Form3.pdf"  # अपनी PDF का नाम
output_folder = "output_images"  # इमेज को सेव करने के लिए फोल्डर
output_json_file = "output_data.json"  # JSON आउटपुट फाइल

# आउटपुट फोल्डर बनाएं यदि यह मौजूद नहीं है
if not os.path.exists(output_folder):
    os.makedirs(output_folder)

# JSON डेटा स्टोर करने के लिए लिस्ट
output_data = []

# PDF को खोलें और प्रोसेस करें
try:
    pdf_document = fitz.open(input_pdf)
    print(f"Processing PDF: {input_pdf}")
    
    # प्रत्येक पेज को इमेज में बदलें
    for page_number in range(len(pdf_document)):
        page = pdf_document[page_number]
        
        # पेज को पिक्सेल-आधारित इमेज में बदलें
        pix = page.get_pixmap(dpi=300)  # DPI क्वालिटी सेट करें
        
        # इमेज को PNG के रूप में सेव करें
        output_path = os.path.join(output_folder, f"page_{page_number + 1}.png")
        pix.save(output_path)
        print(f"Saved: {output_path}")
        
        # JSON डेटा में पेज की जानकारी जोड़ें
        output_data.append({
            "page_number": page_number + 1,
            "image_path": output_path,
            "status": "converted"
        })
    
    pdf_document.close()
    print("Conversion completed successfully!")

    # JSON फाइल में डेटा लिखें
    with open(output_json_file, "w") as json_file:
        json.dump(output_data, json_file, indent=4)
    print(f"JSON data written to: {output_json_file}")

except Exception as e:
    print(f"Error: {e}")
    output_data.append({
        "error": str(e),
        "status": "failed"
    })

    # यदि एरर हो, तो JSON में लिखें
    with open(output_json_file, "w") as json_file:
        json.dump(output_data, json_file, indent=4)
