const i18n = ({locale}) => {
    switch (locale) {
        case 'vi': 
            return {
                choices_no_result: 'Không có kết quả',
                choices_press_enter: 'Nhấn để chọn',
                alert_success: 'Thành công',
                alert_error: 'Thất bại',
            }
        default: 
            return {
                choices_no_result: 'No results found',
                choices_press_enter: 'Press to select',
                alert_success: 'Successfully',
                alert_error: 'Failure',
            }
    }
}

export default i18n;