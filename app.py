from flask import Flask, render_template, request, redirect, url_for , jsonify
from werkzeug.utils import secure_filename
from flask_cors import CORS, cross_origin
from pdfminer.high_level import extract_pages
from pdfminer.layout import LTTextLineHorizontal, LTTextBoxHorizontal

app = Flask(__name__)


# Configure the upload folder and allowed extensions for uploaded files
app.config['UPLOAD_FOLDER'] = './api/upload'
app.config['ALLOWED_EXTENSIONS'] = {'pdf'}

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in app.config['ALLOWED_EXTENSIONS']

def extract_text_by_bbox(input_pdf_path, bboxes):
    text_data = {}

    for bbox_name, bbox in bboxes.items():
        text_lines = []
        x1, y1, x2, y2 = bbox

        for page_layout in extract_pages(input_pdf_path):
            for element in page_layout:
                if isinstance(element, LTTextBoxHorizontal):
                    for text_line in element:
                        if isinstance(text_line, LTTextLineHorizontal):
                            if (text_line.x0 >= x1 and text_line.x1 <= x2 and
                                text_line.y0 >= y1 and text_line.y1 <= y2):
                                text_lines.append(text_line.get_text().strip())

        text_data[bbox_name] = '\n'.join(text_lines)
    
    return text_data

cors = CORS(app)
app.config['CORS_HEADERS'] = 'Content-Type'
# @app.route('/api/mia', methods=['GET', 'POST'])
@app.route('/api/mia', methods=['POST'])
@cross_origin()

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
            file_path = f"{app.config['UPLOAD_FOLDER']}/{filename}"
            file.save(file_path)
            
            # Bounding box coordinates for extraction
            bboxes = {
                'cons': (419.0, 599.85, 430.676, 606.85),
                'init': (187.0, 726.04, 255.427, 735.04),
                'monthly_cons': (55.79, 625.13, 63.998, 631.13),
                'price' : (467.0, 599.85, 484.507, 606.85)
            }
            
            # Extract text within the specified bounding boxes
            extracted_data = extract_text_by_bbox(file_path, bboxes)
            
            # Render the template with extracted information
            # return render_template('return.html', extracted_data=extracted_data)
            return jsonify(extracted_data)
        
    # Render the upload form
    # return render_template('upload.php')

if __name__ == '__main__':
    app.run(debug=True, port=8887,host='localhost')

