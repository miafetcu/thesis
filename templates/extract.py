from flask import Flask, render_template, request, redirect, url_for
from werkzeug.utils import secure_filename
from pdfminer.high_level import extract_pages
from pdfminer.layout import LTTextLineHorizontal, LTTextBoxHorizontal
import os

app = Flask(__name__)

# Configure the upload folder and allowed extensions for uploaded files
app.config['UPLOAD_FOLDER'] = 'uploads'
app.config['ALLOWED_EXTENSIONS'] = {'pdf'}

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in app.config['ALLOWED_EXTENSIONS']

def extract_text_with_bbox(input_pdf_path):
    text_with_bbox = []

    for page_layout in extract_pages(input_pdf_path):
        for element in page_layout:
            if isinstance(element, LTTextBoxHorizontal):
                for text_line in element:
                    if isinstance(text_line, LTTextLineHorizontal):
                        # Extract text line and its bounding box coordinates
                        bbox = (text_line.x0, text_line.y0, text_line.x1, text_line.y1)
                        text_content = text_line.get_text().strip()
                        text_with_bbox.append((text_content, bbox))

    return text_with_bbox

@app.route('/', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        # Check if the post request has the file part
        if 'pdf_file' not in request.files:
            return redirect(request.url)
        
        file = request.files['pdf_file']
        
        # If the user does not select a file, the browser submits an empty file without filename
        if file.filename == '':
            return redirect(request.url)
        
        if file and allowed_file(file.filename):
            # Save the uploaded PDF file
            filename = secure_filename(file.filename)
            file_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
            file.save(file_path)
            
            # Extract text with bounding box coordinates from the entire PDF
            extracted_text_with_bbox = extract_text_with_bbox(file_path)
            
            # Render the template with extracted text and bounding box coordinates
            return render_template('extracted_pdf.html', extracted_text_with_bbox=extracted_text_with_bbox)
    
    # Render the upload form
    return render_template('upload_form.html')

if __name__ == '__main__':
    app.run(debug=True, port=5001)

